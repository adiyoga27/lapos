<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Hutang;
use App\Models\Kas;
use App\Models\Pembelian;
use App\Models\ItemPembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembelian::with(['supplierRef', 'kas', 'itemPembelian']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('supplierRef', function ($sq) use ($search) {
                      $sq->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('supplier')) {
            $query->where('supplier', $request->supplier);
        }

        $pembelian = $query->orderBy('tanggal', 'desc')->orderBy('kode', 'desc')->paginate(20);

        if ($request->ajax()) {
            return response()->json($pembelian);
        }

        $supplierList = Supplier::orderBy('nama')->get();
        return view('transaksi.pembelian.index', compact('pembelian', 'supplierList'));
    }

    public function create()
    {
        $supplierList = Supplier::orderBy('nama')->get();
        $kasList = Kas::orderBy('nama')->get();
        return view('transaksi.pembelian.create', compact('supplierList', 'kasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.kode_barang' => 'required|string',
            'items.*.nama_barang' => 'required|string',
            'items.*.qty' => 'required|numeric|min:0.01',
            'items.*.harga' => 'required|numeric|min:0',
            'items.*.satuan' => 'nullable|string',
            'supplier' => 'required|string|exists:supplier,kode',
            'kode_kas' => 'required|string|exists:kas,kode',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:tunai,kredit',
            'diskon' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $kode = 'PM-' . date('YmdHis') . rand(100, 999);

            $items = $request->items;
            $subtotal = 0;
            foreach ($items as $item) {
                $qty = (float) $item['qty'];
                $harga = (float) $item['harga'];
                $itemJumlah = $qty * $harga;
                $subtotal += $itemJumlah;
            }

            $diskonRupiah = (float) ($request->diskon ?? 0);
            $taxPersen = (float) ($request->tax ?? 0);
            $setelahDiskon = $subtotal - $diskonRupiah;
            $taxRupiah = $setelahDiskon * ($taxPersen / 100);
            $jumlah = $setelahDiskon + $taxRupiah;

            $supplier = Supplier::find($request->supplier);

            $pembelian = Pembelian::create([
                'kode' => $kode,
                'tanggal' => $request->tanggal,
                'supplier' => $request->supplier,
                'kode_kas' => $request->kode_kas,
                'keterangan' => $request->keterangan,
                'diskon' => $diskonRupiah,
                'tax' => $taxPersen,
                'jumlah' => $jumlah,
                'operator' => auth()->user() ? auth()->user()->name : 'System',
                'jt' => $request->tanggal,
                'lunas' => $request->jenis === 'tunai' ? 1 : 0,
                'hutang' => $request->jenis === 'kredit' ? 1 : 0,
            ]);

            foreach ($items as $item) {
                $qty = (float) $item['qty'];
                $harga = (float) $item['harga'];
                $itemJumlah = $qty * $harga;

                ItemPembelian::create([
                    'kode' => $kode,
                    'kode_barang' => $item['kode_barang'],
                    'nama_barang' => $item['nama_barang'],
                    'satuan' => $item['satuan'] ?? 'PCS',
                    'qty' => $qty,
                    'harga' => $harga,
                    'jumlah' => $itemJumlah,
                    'subtotal' => $itemJumlah,
                    'hpp' => $harga,
                    'harga_toko' => $item['harga_toko'] ?? 0,
                ]);

                $barang = Barang::find($item['kode_barang']);
                if ($barang) {
                    $barang->toko = (float) $barang->toko + $qty;
                    $barang->hpp = $harga;
                    $barang->save();
                }
            }

            if ($request->jenis === 'tunai') {
                $kas = Kas::find($request->kode_kas);
                if ($kas) {
                    $kas->saldo = max(0, (float) $kas->saldo - $jumlah);
                    $kas->save();
                }
            }

            if ($request->jenis === 'kredit') {
                $hutangKode = 'HT-' . date('YmdHis') . rand(100, 999);
                Hutang::create([
                    'kode' => $hutangKode,
                    'tanggal' => $request->tanggal,
                    'supplier' => $request->supplier,
                    'alamat' => $supplier->alamat ?? null,
                    'jumlah' => $jumlah,
                    'kode_kas' => $request->kode_kas,
                    'ket' => 'Pembelian kredit ' . $kode,
                    'operator' => auth()->user() ? auth()->user()->name : 'System',
                ]);

                if ($supplier) {
                    $supplier->saldo_piutang = (float) $supplier->saldo_piutang + $jumlah;
                    $supplier->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'kode' => $kode,
                'message' => 'Pembelian berhasil disimpan',
                'data' => $pembelian->load(['itemPembelian', 'supplierRef']),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($kode)
    {
        $pembelian = Pembelian::with(['itemPembelian.barang', 'supplierRef', 'kas', 'itemHutang'])
            ->where('kode', $kode)
            ->firstOrFail();

        if (request()->ajax()) {
            return response()->json($pembelian);
        }

        return view('transaksi.pembelian.show', compact('pembelian'));
    }

    public function getSupplier($search)
    {
        $supplier = Supplier::where('nama', 'like', "%{$search}%")
            ->orWhere('kode', 'like', "%{$search}%")
            ->limit(15)
            ->get(['kode', 'nama', 'alamat', 'saldo_piutang']);

        return response()->json([
            'success' => true,
            'data' => $supplier,
        ]);
    }

    public function getProduct($kode)
    {
        $barang = Barang::where('kode', $kode)
            ->orWhere('kode_barcode', $kode)
            ->first();

        if (!$barang) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'kode' => $barang->kode,
                'nama' => $barang->nama,
                'hpp' => (float) $barang->hpp,
                'harga_toko' => (float) $barang->harga_toko,
                'stok' => (float) $barang->toko,
                'satuan' => $barang->satuan,
            ],
        ]);
    }
}
