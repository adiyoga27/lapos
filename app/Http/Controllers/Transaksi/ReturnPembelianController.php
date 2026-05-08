<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kas;
use App\Models\Pembelian;
use App\Models\ReturnPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnPembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnPembelian::with(['barang', 'supplierRef', 'pembelian']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('no_faktur', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $returnPembelian = $query->orderBy('tanggal', 'desc')->orderBy('kode', 'desc')->paginate(20);

        if ($request->ajax()) {
            return response()->json($returnPembelian);
        }

        return view('transaksi.return_pembelian.index', compact('returnPembelian'));
    }

    public function create()
    {
        $pembelianList = Pembelian::orderBy('tanggal', 'desc')->limit(200)->get(['kode', 'tanggal', 'supplier']);
        $kasList = Kas::orderBy('nama')->get();
        return view('transaksi.return_pembelian.create', compact('pembelianList', 'kasList'));
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
            'items.*.no_faktur' => 'nullable|string',
            'items.*.tgl_beli' => 'nullable|date',
            'items.*.supplier' => 'nullable|string',
            'items.*.alasan' => 'nullable|string',
            'tanggal' => 'required|date',
            'kode_kas' => 'nullable|string|exists:kas,kode',
            'refund' => 'nullable|in:ya,tidak',
        ]);

        DB::beginTransaction();
        try {
            $kodeHeader = 'RP-' . date('YmdHis') . rand(100, 999);
            $totalRefund = 0;

            foreach ($request->items as $item) {
                $qty = (float) $item['qty'];
                $harga = (float) $item['harga'];
                $jumlah = $qty * $harga;

                ReturnPembelian::create([
                    'kode' => $kodeHeader,
                    'tanggal' => $request->tanggal,
                    'kode_barang' => $item['kode_barang'],
                    'nama_barang' => $item['nama_barang'],
                    'satuan' => $item['satuan'] ?? 'PCS',
                    'no_faktur' => $item['no_faktur'] ?? null,
                    'tgl_beli' => $item['tgl_beli'] ?? null,
                    'supplier' => $item['supplier'] ?? null,
                    'qty' => $qty,
                    'harga' => $harga,
                    'jumlah' => $jumlah,
                    'alasan' => $item['alasan'] ?? null,
                    'kode_kas' => $request->kode_kas,
                    'operator' => auth()->user() ? auth()->user()->name : 'System',
                    'kembali' => 1,
                ]);

                $barang = Barang::find($item['kode_barang']);
                if ($barang) {
                    $barang->toko = max(0, (float) $barang->toko - $qty);
                    $barang->save();
                }

                $totalRefund += $jumlah;
            }

            if ($request->refund === 'ya' && $request->kode_kas) {
                $kas = Kas::find($request->kode_kas);
                if ($kas) {
                    $kas->saldo = (float) $kas->saldo + $totalRefund;
                    $kas->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'kode' => $kodeHeader,
                'message' => 'Return pembelian berhasil disimpan',
                'total_refund' => $totalRefund,
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
        $returnPembelian = ReturnPembelian::with(['barang', 'supplierRef', 'pembelian'])
            ->where('kode', $kode)
            ->get();

        if (request()->ajax()) {
            return response()->json($returnPembelian);
        }

        return view('transaksi.return_pembelian.show', compact('returnPembelian', 'kode'));
    }

    public function destroy($kode)
    {
        DB::beginTransaction();
        try {
            $returns = ReturnPembelian::where('kode', $kode)->get();

            foreach ($returns as $ret) {
                $barang = Barang::find($ret->kode_barang);
                if ($barang) {
                    $barang->toko = (float) $barang->toko + (float) $ret->qty;
                    $barang->save();
                }
            }

            ReturnPembelian::where('kode', $kode)->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Return pembelian berhasil dihapus']);
            }

            return redirect()->route('return_pembelian.index')->with('success', 'Return pembelian berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
