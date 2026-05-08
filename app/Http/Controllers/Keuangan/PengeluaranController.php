<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Biaya;
use App\Models\Kas;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::with(['biaya', 'kas']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kd_biaya')) {
            $query->where('kd_biaya', $request->kd_biaya);
        }

        if ($request->filled('kode_kas')) {
            $query->where('kode_kas', $request->kode_kas);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $pengeluaran = $query->orderBy('tanggal', 'desc')->orderBy('kode', 'desc')->paginate(20);

        $biayaList = Biaya::orderBy('nama')->get();
        $kasList = Kas::orderBy('nama')->get();

        if ($request->ajax()) {
            return response()->json($pengeluaran);
        }

        return view('keuangan.pengeluaran.index', compact('pengeluaran', 'biayaList', 'kasList'));
    }

    public function create()
    {
        $biayaList = Biaya::orderBy('nama')->get();
        $kasList = Kas::orderBy('nama')->get();
        return view('keuangan.pengeluaran.create', compact('biayaList', 'kasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kd_biaya' => 'required|string|exists:biaya,kode',
            'kode_kas' => 'required|string|exists:kas,kode',
            'jumlah' => 'required|numeric|min:0.01',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $kode = 'OUT-' . date('YmdHis') . rand(100, 999);

            $pengeluaran = Pengeluaran::create([
                'kode' => $kode,
                'tanggal' => $request->tanggal,
                'kd_biaya' => $request->kd_biaya,
                'keterangan' => $request->keterangan,
                'kode_kas' => $request->kode_kas,
                'jumlah' => $request->jumlah,
                'operator' => auth()->user() ? auth()->user()->name : 'System',
            ]);

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
                    'message' => 'Pengeluaran berhasil disimpan',
                    'data' => $pengeluaran->load(['biaya', 'kas']),
                ]);
            }

            return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil disimpan');
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
        $pengeluaran = Pengeluaran::with(['biaya', 'kas'])
            ->where('kode', $kode)
            ->firstOrFail();

        if (request()->ajax()) {
            return response()->json($pengeluaran);
        }

        return view('keuangan.pengeluaran.show', compact('pengeluaran'));
    }

    public function destroy($kode)
    {
        DB::beginTransaction();
        try {
            $pengeluaran = Pengeluaran::where('kode', $kode)->firstOrFail();

            $kas = Kas::find($pengeluaran->kode_kas);
            if ($kas) {
                $kas->saldo = (float) $kas->saldo + (float) $pengeluaran->jumlah;
                $kas->save();
            }

            $pengeluaran->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Pengeluaran berhasil dihapus']);
            }

            return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
