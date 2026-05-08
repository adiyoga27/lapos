<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Biaya;
use App\Models\Kas;
use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemasukan::with(['biaya', 'kas']);

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

        $pemasukan = $query->orderBy('tanggal', 'desc')->orderBy('kode', 'desc')->paginate(20);

        $biayaList = Biaya::orderBy('nama')->get();
        $kasList = Kas::orderBy('nama')->get();

        if ($request->ajax()) {
            return response()->json($pemasukan);
        }

        return view('keuangan.pemasukan.index', compact('pemasukan', 'biayaList', 'kasList'));
    }

    public function create()
    {
        $biayaList = Biaya::orderBy('nama')->get();
        $kasList = Kas::orderBy('nama')->get();
        return view('keuangan.pemasukan.create', compact('biayaList', 'kasList'));
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
            $kode = 'IN-' . date('YmdHis') . rand(100, 999);

            $pemasukan = Pemasukan::create([
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
                $kas->saldo = (float) $kas->saldo + (float) $request->jumlah;
                $kas->save();
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'kode' => $kode,
                    'message' => 'Pemasukan berhasil disimpan',
                    'data' => $pemasukan->load(['biaya', 'kas']),
                ]);
            }

            return redirect()->route('pemasukan.index')->with('success', 'Pemasukan berhasil disimpan');
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
        $pemasukan = Pemasukan::with(['biaya', 'kas'])
            ->where('kode', $kode)
            ->firstOrFail();

        if (request()->ajax()) {
            return response()->json($pemasukan);
        }

        return view('keuangan.pemasukan.show', compact('pemasukan'));
    }

    public function destroy($kode)
    {
        DB::beginTransaction();
        try {
            $pemasukan = Pemasukan::where('kode', $kode)->firstOrFail();

            $kas = Kas::find($pemasukan->kode_kas);
            if ($kas) {
                $kas->saldo = max(0, (float) $kas->saldo - (float) $pemasukan->jumlah);
                $kas->save();
            }

            $pemasukan->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Pemasukan berhasil dihapus']);
            }

            return redirect()->route('pemasukan.index')->with('success', 'Pemasukan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
