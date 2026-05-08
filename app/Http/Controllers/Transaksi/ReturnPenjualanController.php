<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kas;
use App\Models\Penjualan;
use App\Models\Piutang;
use App\Models\ReturnPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = ReturnPenjualan::with(['barang', 'penjualan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('no_faktur', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_header', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $returnPenjualan = $query->orderBy('tanggal', 'desc')->orderBy('kode', 'desc')->paginate(20);

        if ($request->ajax()) {
            return response()->json($returnPenjualan);
        }

        return view('transaksi.return_penjualan.index', compact('returnPenjualan'));
    }

    public function create()
    {
        $penjualanList = Penjualan::orderBy('tanggal', 'desc')->limit(200)->get(['kode', 'tanggal', 'nama_pelanggan']);
        $kasList = Kas::orderBy('nama')->get();
        return view('transaksi.return_penjualan.create', compact('penjualanList', 'kasList'));
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
            'items.*.tgl_jual' => 'nullable|date',
            'items.*.alasan' => 'nullable|string',
            'jenis_penjualan' => 'nullable|string',
            'tanggal' => 'required|date',
            'kode_kas' => 'nullable|string|exists:kas,kode',
            'refund' => 'nullable|in:ya,tidak',
        ]);

        DB::beginTransaction();
        try {
            $kodeHeader = 'RJ-' . date('YmdHis') . rand(100, 999);
            $totalRefund = 0;

            foreach ($request->items as $item) {
                $qty = (float) $item['qty'];
                $harga = (float) $item['harga'];
                $diskon = (float) ($item['diskon'] ?? 0);
                $jumlah = ($qty * $harga) - $diskon;

                $returnData = [
                    'kode' => $kodeHeader,
                    'kode_header' => $kodeHeader,
                    'tanggal' => $request->tanggal,
                    'jenis_penjualan' => $request->jenis_penjualan ?? 'tunai',
                    'no_faktur' => $item['no_faktur'] ?? null,
                    'tgl_jual' => $item['tgl_jual'] ?? null,
                    'kode_barang' => $item['kode_barang'],
                    'nama_barang' => $item['nama_barang'],
                    'satuan' => $item['satuan'] ?? 'PCS',
                    'qty' => $qty,
                    'harga' => $harga,
                    'diskon' => $diskon,
                    'jumlah' => $jumlah,
                    'alasan' => $item['alasan'] ?? null,
                    'kode_kas' => $request->kode_kas,
                    'operator' => auth()->user() ? auth()->user()->name : 'System',
                    'tipe' => 'return',
                ];

                $barang = Barang::find($item['kode_barang']);
                if ($barang) {
                    $returnData['hpp'] = (float) $barang->hpp;
                }

                ReturnPenjualan::create($returnData);

                if ($barang) {
                    $barang->toko = (float) $barang->toko + $qty;
                    $barang->save();
                }

                $totalRefund += $jumlah;
            }

            if ($request->refund === 'ya' && $request->kode_kas) {
                $kas = Kas::find($request->kode_kas);
                if ($kas) {
                    $kas->saldo = max(0, (float) $kas->saldo - $totalRefund);
                    $kas->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'kode' => $kodeHeader,
                'message' => 'Return penjualan berhasil disimpan',
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
        $returnPenjualan = ReturnPenjualan::with(['barang', 'penjualan'])
            ->where('kode', $kode)
            ->get();

        if (request()->ajax()) {
            return response()->json($returnPenjualan);
        }

        return view('transaksi.return_penjualan.show', compact('returnPenjualan', 'kode'));
    }

    public function destroy($kode)
    {
        DB::beginTransaction();
        try {
            $returns = ReturnPenjualan::where('kode', $kode)->get();

            foreach ($returns as $ret) {
                $barang = Barang::find($ret->kode_barang);
                if ($barang) {
                    $barang->toko = max(0, (float) $barang->toko - (float) $ret->qty);
                    $barang->save();
                }
            }

            ReturnPenjualan::where('kode', $kode)->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Return penjualan berhasil dihapus']);
            }

            return redirect()->route('return_penjualan.index')->with('success', 'Return penjualan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
