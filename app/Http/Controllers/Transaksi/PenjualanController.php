<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kas;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\ItemPenjualan;
use App\Models\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::with(['pelangganRef', 'kas', 'itemPenjualan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $penjualan = $query->orderBy('tanggal', 'desc')->orderBy('kode', 'desc')->paginate(20);

        if ($request->ajax()) {
            return response()->json($penjualan);
        }

        return view('transaksi.penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $kasList = Kas::orderBy('nama')->get();
        $pelangganList = Pelanggan::orderBy('nama')->get();
        return view('transaksi.penjualan.create', compact('kasList', 'pelangganList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.kode_barang' => 'required|string',
            'items.*.nama_barang' => 'required|string',
            'items.*.qty' => 'required|numeric|min:0.01',
            'items.*.harga' => 'required|numeric|min:0',
            'items.*.diskon' => 'nullable|numeric|min:0',
            'items.*.satuan' => 'nullable|string',
            'pelanggan' => 'nullable|string',
            'kode_kas' => 'required|string|exists:kas,kode',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:tunai,kredit,debit',
            'diskon' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $kode = 'JL-' . date('YmdHis') . rand(100, 999);

            $items = $request->items;
            $subtotal = 0;
            foreach ($items as $item) {
                $qty = (float) $item['qty'];
                $harga = (float) $item['harga'];
                $diskonItem = (float) ($item['diskon'] ?? 0);
                $itemSubtotal = ($qty * $harga) - $diskonItem;
                $subtotal += $itemSubtotal;
            }

            $diskonRupiah = (float) ($request->diskon ?? 0);
            $taxPersen = (float) ($request->tax ?? 0);
            $setelahDiskon = $subtotal - $diskonRupiah;
            $taxRupiah = $setelahDiskon * ($taxPersen / 100);
            $jumlah = $setelahDiskon + $taxRupiah;
            $bayar = (float) $request->bayar;
            $kembali = max(0, $bayar - $jumlah);

            $pelanggan = $request->pelanggan;
            $namaPelanggan = null;
            $alamatPelanggan = null;
            if ($pelanggan) {
                $plg = Pelanggan::find($pelanggan);
                if ($plg) {
                    $namaPelanggan = $plg->nama;
                    $alamatPelanggan = $plg->alamat;
                }
            }

            $penjualan = Penjualan::create([
                'kode' => $kode,
                'tanggal' => $request->tanggal,
                'pelanggan' => $pelanggan,
                'nama_pelanggan' => $namaPelanggan,
                'alamat_pelanggan' => $alamatPelanggan,
                'kode_kas' => $request->kode_kas,
                'keterangan' => $request->keterangan,
                'subtotal' => $subtotal,
                'diskon' => $diskonRupiah,
                'tax' => $taxPersen,
                'tax_rupiah' => $taxRupiah,
                'jumlah' => $jumlah,
                'bayar' => $bayar,
                'kembali' => $kembali,
                'operator' => auth()->user() ? auth()->user()->name : 'System',
                'jenis' => $request->jenis,
                'lunas' => ($request->jenis === 'tunai' || $request->jenis === 'debit') ? 1 : 0,
                'visa' => $request->jenis === 'debit' ? 1 : 0,
                'jt' => $request->tanggal,
            ]);

            foreach ($items as $item) {
                $qty = (float) $item['qty'];
                $harga = (float) $item['harga'];
                $diskonItem = (float) ($item['diskon'] ?? 0);
                $itemSubtotal = ($qty * $harga) - $diskonItem;

                $barang = Barang::find($item['kode_barang']);
                $hpp = $barang ? (float) $barang->hpp : 0;

                ItemPenjualan::create([
                    'kode' => $kode,
                    'kode_barang' => $item['kode_barang'],
                    'nama_barang' => $item['nama_barang'],
                    'satuan' => $item['satuan'] ?? 'PCS',
                    'qty' => $qty,
                    'harga' => $harga,
                    'subtotal' => $itemSubtotal,
                    'diskon' => $diskonItem,
                    'hpp' => $hpp,
                    'harga_awal' => $harga,
                ]);

                if ($barang) {
                    $barang->toko = max(0, (float) $barang->toko - $qty);
                    $barang->save();
                }
            }

            if ($request->jenis === 'tunai' || $request->jenis === 'debit') {
                $kas = Kas::find($request->kode_kas);
                if ($kas) {
                    $kas->saldo = (float) $kas->saldo + $jumlah;
                    $kas->save();
                }
            }

            if ($request->jenis === 'kredit' && $pelanggan) {
                Piutang::create([
                    'kode' => 'PT-' . date('YmdHis') . rand(100, 999),
                    'tanggal' => $request->tanggal,
                    'pelanggan' => $pelanggan,
                    'alamat' => $alamatPelanggan,
                    'jumlah' => $jumlah,
                    'kode_kas' => $request->kode_kas,
                    'ket' => 'Penjualan kredit ' . $kode,
                    'operator' => auth()->user() ? auth()->user()->name : 'System',
                ]);

                if ($plg ?? false) {
                    $plg->saldo_piutang = (float) $plg->saldo_piutang + $jumlah;
                    $plg->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'kode' => $kode,
                'message' => 'Transaksi berhasil disimpan',
                'data' => $penjualan->load(['itemPenjualan', 'pelangganRef']),
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
        $penjualan = Penjualan::with(['itemPenjualan.barang', 'pelangganRef', 'kas', 'piutang'])
            ->where('kode', $kode)
            ->firstOrFail();

        if (request()->ajax()) {
            return response()->json($penjualan);
        }

        return view('transaksi.penjualan.show', compact('penjualan'));
    }

    public function destroy($kode)
    {
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::with('itemPenjualan')->where('kode', $kode)->firstOrFail();

            foreach ($penjualan->itemPenjualan as $item) {
                $barang = Barang::find($item->kode_barang);
                if ($barang) {
                    $barang->toko = (float) $barang->toko + (float) $item->qty;
                    $barang->save();
                }
            }

            if ($penjualan->jenis === 'tunai' || $penjualan->jenis === 'debit') {
                $kas = Kas::find($penjualan->kode_kas);
                if ($kas) {
                    $kas->saldo = max(0, (float) $kas->saldo - (float) $penjualan->jumlah);
                    $kas->save();
                }
            }

            if ($penjualan->jenis === 'kredit') {
                Piutang::where('ket', 'like', '%' . $kode . '%')->delete();
                if ($penjualan->pelanggan) {
                    $plg = Pelanggan::find($penjualan->pelanggan);
                    if ($plg) {
                        $plg->saldo_piutang = max(0, (float) $plg->saldo_piutang - (float) $penjualan->jumlah);
                        $plg->save();
                    }
                }
            }

            $penjualan->itemPenjualan()->delete();
            $penjualan->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Transaksi berhasil dibatalkan']);
            }

            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dibatalkan');
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getProduct($kode)
    {
        $barang = Barang::where('kode', $kode)
            ->orWhere('kode_barcode', $kode)
            ->orWhere('kode_barcode2', $kode)
            ->orWhere('kode_barcode3', $kode)
            ->first();

        if (!$barang) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'kode' => $barang->kode,
                'nama' => $barang->nama,
                'harga_toko' => (float) $barang->harga_toko,
                'harga_partai' => (float) $barang->harga_partai,
                'harga_cabang' => (float) $barang->harga_cabang,
                'stok' => (float) $barang->toko,
                'satuan' => $barang->satuan,
                'hpp' => (float) $barang->hpp,
                'diskon' => (float) $barang->diskon,
            ],
        ]);
    }

    public function getPelanggan($search)
    {
        $pelanggan = Pelanggan::where('nama', 'like', "%{$search}%")
            ->orWhere('kode', 'like', "%{$search}%")
            ->limit(15)
            ->get(['kode', 'nama', 'alamat', 'saldo_piutang']);

        return response()->json([
            'success' => true,
            'data' => $pelanggan,
        ]);
    }
}
