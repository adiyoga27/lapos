<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Hutang;
use App\Models\ItemHutang;
use App\Models\Kas;
use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HutangController extends Controller
{
    public function index(Request $request)
    {
        $query = Hutang::with(['supplierRef', 'itemHutang.pembelian']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhereHas('supplierRef', function ($sq) use ($search) {
                      $sq->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('supplier')) {
            $query->where('supplier', $request->supplier);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $hutang = $query->orderBy('tanggal', 'desc')->orderBy('kode', 'desc')->paginate(20);

        $supplierList = Supplier::orderBy('nama')->get();

        if ($request->ajax()) {
            return response()->json($hutang);
        }

        return view('keuangan.hutang.index', compact('hutang', 'supplierList'));
    }

    public function create()
    {
        $supplierList = Supplier::orderBy('nama')->get();
        $kasList = Kas::orderBy('nama')->get();

        $pembelianHutang = Pembelian::where('hutang', 1)
            ->where('lunas', 0)
            ->with('supplierRef')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('keuangan.hutang.create', compact('supplierList', 'kasList', 'pembelianHutang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier' => 'required|string|exists:supplier,kode',
            'kode_kas' => 'required|string|exists:kas,kode',
            'jumlah' => 'required|numeric|min:0.01',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'pembelian' => 'nullable|array',
            'pembelian.*.kode' => 'nullable|string',
            'pembelian.*.jumlah' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $kode = 'BY-HT-' . date('YmdHis') . rand(100, 999);

            $hutang = Hutang::create([
                'kode' => $kode,
                'tanggal' => $request->tanggal,
                'supplier' => $request->supplier,
                'alamat' => $request->alamat,
                'jumlah' => $request->jumlah,
                'kode_kas' => $request->kode_kas,
                'ket' => $request->keterangan,
                'operator' => auth()->user() ? auth()->user()->name : 'System',
            ]);

            if ($request->has('pembelian') && is_array($request->pembelian)) {
                foreach ($request->pembelian as $pb) {
                    if (!empty($pb['kode']) && (float) ($pb['jumlah'] ?? 0) > 0) {
                        $pembelian = Pembelian::find($pb['kode']);
                        ItemHutang::create([
                            'kode' => $kode,
                            'kode_hutang' => $kode,
                            'kode_pembelian' => $pb['kode'],
                            'tgl_pembelian' => $pembelian ? $pembelian->tanggal : $request->tanggal,
                            'jum_pembelian' => $pembelian ? $pembelian->jumlah : 0,
                            'jum_pembayaran' => $pb['jumlah'],
                        ]);

                        if ($pembelian) {
                            $totalBayar = ItemHutang::where('kode_pembelian', $pb['kode'])->sum('jum_pembayaran');
                            if ($totalBayar >= (float) $pembelian->jumlah) {
                                $pembelian->lunas = 1;
                                $pembelian->save();
                            }
                        }
                    }
                }
            }

            $supplier = Supplier::find($request->supplier);
            if ($supplier) {
                $supplier->saldo_piutang = max(0, (float) $supplier->saldo_piutang - (float) $request->jumlah);
                $supplier->save();
            }

            $kas = Kas::find($request->kode_kas);
            if ($kas) {
                $kas->saldo = max(0, (float) $kas->saldo - (float) $request->jumlah);
                $kas->save();
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'kode' => $kode,
                    'message' => 'Pembayaran hutang berhasil disimpan',
                    'data' => $hutang->load('supplierRef'),
                ]);
            }

            return redirect()->route('hutang.index')->with('success', 'Pembayaran hutang berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($kode)
    {
        $hutang = Hutang::with(['supplierRef', 'itemHutang.pembelian.supplierRef'])
            ->where('kode', $kode)
            ->firstOrFail();

        if (request()->ajax()) {
            return response()->json($hutang);
        }

        return view('keuangan.hutang.show', compact('hutang'));
    }

    public function destroy($kode)
    {
        DB::beginTransaction();
        try {
            $hutang = Hutang::with('itemHutang')->where('kode', $kode)->firstOrFail();

            foreach ($hutang->itemHutang as $item) {
                $pembelian = Pembelian::find($item->kode_pembelian);
                if ($pembelian) {
                    $pembelian->lunas = 0;
                    $pembelian->save();
                }
            }

            $supplier = Supplier::find($hutang->supplier);
            if ($supplier) {
                $supplier->saldo_piutang = (float) $supplier->saldo_piutang + (float) $hutang->jumlah;
                $supplier->save();
            }

            $kas = Kas::find($hutang->kode_kas);
            if ($kas) {
                $kas->saldo = (float) $kas->saldo + (float) $hutang->jumlah;
                $kas->save();
            }

            $hutang->itemHutang()->delete();
            $hutang->delete();

            DB::commit();

            return redirect()->route('hutang.index')->with('success', 'Pembayaran hutang berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
