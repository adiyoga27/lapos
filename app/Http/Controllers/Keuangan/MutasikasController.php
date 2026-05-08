<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Kas;
use App\Models\MutasiKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MutasikasController extends Controller
{
    public function index(Request $request)
    {
        $query = MutasiKas::with(['kasDari', 'kasKe']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        $mutasikas = $query->orderBy('tanggal', 'desc')->orderBy('kode', 'desc')->paginate(20);

        $kasList = Kas::orderBy('nama')->get();

        if ($request->ajax()) {
            return response()->json($mutasikas);
        }

        return view('keuangan.mutasikas.index', compact('mutasikas', 'kasList'));
    }

    public function create()
    {
        $kasList = Kas::orderBy('nama')->get();
        return view('keuangan.mutasikas.create', compact('kasList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dari' => 'required|string|exists:kas,kode|different:ke',
            'ke' => 'required|string|exists:kas,kode',
            'jumlah' => 'required|numeric|min:0.01',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $kode = 'MK-' . date('YmdHis') . rand(100, 999);

            $mutasi = MutasiKas::create([
                'kode' => $kode,
                'tanggal' => $request->tanggal,
                'dari' => $request->dari,
                'ke' => $request->ke,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'operator' => auth()->user() ? auth()->user()->name : 'System',
            ]);

            $kasDari = Kas::find($request->dari);
            if ($kasDari) {
                $kasDari->saldo = max(0, (float) $kasDari->saldo - (float) $request->jumlah);
                $kasDari->save();
            }

            $kasKe = Kas::find($request->ke);
            if ($kasKe) {
                $kasKe->saldo = (float) $kasKe->saldo + (float) $request->jumlah;
                $kasKe->save();
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'kode' => $kode,
                    'message' => 'Mutasi kas berhasil disimpan',
                    'data' => $mutasi->load(['kasDari', 'kasKe']),
                ]);
            }

            return redirect()->route('mutasikas.index')->with('success', 'Mutasi kas berhasil disimpan');
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
        $mutasi = MutasiKas::with(['kasDari', 'kasKe'])
            ->where('kode', $kode)
            ->firstOrFail();

        if (request()->ajax()) {
            return response()->json($mutasi);
        }

        return view('keuangan.mutasikas.show', compact('mutasi'));
    }

    public function destroy($kode)
    {
        DB::beginTransaction();
        try {
            $mutasi = MutasiKas::where('kode', $kode)->firstOrFail();

            $kasDari = Kas::find($mutasi->dari);
            if ($kasDari) {
                $kasDari->saldo = (float) $kasDari->saldo + (float) $mutasi->jumlah;
                $kasDari->save();
            }

            $kasKe = Kas::find($mutasi->ke);
            if ($kasKe) {
                $kasKe->saldo = max(0, (float) $kasKe->saldo - (float) $mutasi->jumlah);
                $kasKe->save();
            }

            $mutasi->delete();

            DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Mutasi kas berhasil dihapus']);
            }

            return redirect()->route('mutasikas.index')->with('success', 'Mutasi kas berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
