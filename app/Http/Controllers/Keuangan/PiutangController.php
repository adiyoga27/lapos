<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\ItemPiutang;
use App\Models\Kas;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PiutangController extends Controller
{
    public function index(Request $request)
    {
        $query = Piutang::with(['pelangganRef', 'itemPiutang.penjualan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhereHas('pelangganRef', function ($sq) use ($search) {
                      $sq->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('pelanggan')) {
            $query->where('pelanggan', $request->pelanggan);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $piutang = $query->orderBy('tanggal', 'desc')->orderBy('kode', 'desc')->paginate(20);

        $pelangganList = Pelanggan::orderBy('nama')->get();

        if ($request->ajax()) {
            return response()->json($piutang);
        }

        return view('keuangan.piutang.index', compact('piutang', 'pelangganList'));
    }

    public function create()
    {
        $pelangganList = Pelanggan::orderBy('nama')->get();
        $kasList = Kas::orderBy('nama')->get();

        $penjualanKredit = Penjualan::where('jenis', 'kredit')
            ->where('lunas', 0)
            ->with('pelangganRef')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('keuangan.piutang.create', compact('pelangganList', 'kasList', 'penjualanKredit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan' => 'required|string|exists:pelanggan,kode',
            'kode_kas' => 'required|string|exists:kas,kode',
            'jumlah' => 'required|numeric|min:0.01',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'penjualan' => 'nullable|array',
            'penjualan.*.kode' => 'nullable|string',
            'penjualan.*.jumlah' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $kode = 'BY-PT-' . date('YmdHis') . rand(100, 999);

            $piutang = Piutang::create([
                'kode' => $kode,
                'tanggal' => $request->tanggal,
                'pelanggan' => $request->pelanggan,
                'alamat' => $request->alamat,
                'jumlah' => $request->jumlah,
                'kode_kas' => $request->kode_kas,
                'ket' => $request->keterangan,
                'operator' => auth()->user() ? auth()->user()->name : 'System',
            ]);

            if ($request->has('penjualan') && is_array($request->penjualan)) {
                foreach ($request->penjualan as $pj) {
                    if (!empty($pj['kode']) && (float) ($pj['jumlah'] ?? 0) > 0) {
                        $penjualan = Penjualan::find($pj['kode']);
                        ItemPiutang::create([
                            'kode' => $kode,
                            'kode_piutang' => $kode,
                            'kode_penjualan' => $pj['kode'],
                            'tgl_penjualan' => $penjualan ? $penjualan->tanggal : $request->tanggal,
                            'jum_penjualan' => $penjualan ? $penjualan->jumlah : 0,
                            'jum_pembayaran' => $pj['jumlah'],
                        ]);

                        if ($penjualan) {
                            $totalBayar = ItemPiutang::where('kode_penjualan', $pj['kode'])->sum('jum_pembayaran');
                            if ($totalBayar >= (float) $penjualan->jumlah) {
                                $penjualan->lunas = 1;
                                $penjualan->save();
                            }
                        }
                    }
                }
            }

            $pelanggan = Pelanggan::find($request->pelanggan);
            if ($pelanggan) {
                $pelanggan->saldo_piutang = max(0, (float) $pelanggan->saldo_piutang - (float) $request->jumlah);
                $pelanggan->save();
            }

            $kas = Kas::find($request->kode_kas);
            if ($kas) {
                $kas->saldo = (float) $kas->saldo + (float) $request->jumlah;
                $kas->save();
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'kode' => $kode,
                    'message' => 'Penerimaan piutang berhasil disimpan',
                    'data' => $piutang->load('pelangganRef'),
                ]);
            }

            return redirect()->route('piutang.index')->with('success', 'Penerimaan piutang berhasil disimpan');
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
        $piutang = Piutang::with(['pelangganRef', 'itemPiutang.penjualan.pelangganRef'])
            ->where('kode', $kode)
            ->firstOrFail();

        if (request()->ajax()) {
            return response()->json($piutang);
        }

        return view('keuangan.piutang.show', compact('piutang'));
    }

    public function destroy($kode)
    {
        DB::beginTransaction();
        try {
            $piutang = Piutang::with('itemPiutang')->where('kode', $kode)->firstOrFail();

            foreach ($piutang->itemPiutang as $item) {
                $penjualan = Penjualan::find($item->kode_penjualan);
                if ($penjualan) {
                    $penjualan->lunas = 0;
                    $penjualan->save();
                }
            }

            $pelanggan = Pelanggan::find($piutang->pelanggan);
            if ($pelanggan) {
                $pelanggan->saldo_piutang = (float) $pelanggan->saldo_piutang + (float) $piutang->jumlah;
                $pelanggan->save();
            }

            $kas = Kas::find($piutang->kode_kas);
            if ($kas) {
                $kas->saldo = max(0, (float) $kas->saldo - (float) $piutang->jumlah);
                $kas->save();
            }

            $piutang->itemPiutang()->delete();
            $piutang->delete();

            DB::commit();

            return redirect()->route('piutang.index')->with('success', 'Penerimaan piutang berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
