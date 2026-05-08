<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('kode')) {
            $query->where('kode', $request->kode);
        }

        $absensi = $query->orderBy('tanggal', 'desc')
            ->orderBy('masuk', 'desc')
            ->paginate(30);

        $karyawanList = Karyawan::where('status', 'aktif')->orderBy('nama')->get();

        if ($request->ajax()) {
            return response()->json($absensi);
        }

        return view('tools.absensi.index', compact('absensi', 'karyawanList'));
    }

    public function create()
    {
        $karyawanList = Karyawan::where('status', 'aktif')->orderBy('nama')->get();
        return view('tools.absensi.create', compact('karyawanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|exists:karyawan,kode',
            'tanggal' => 'required|date',
            'masuk' => 'required|date_format:H:i',
            'keterangan' => 'nullable|string',
        ]);

        $karyawan = Karyawan::find($request->kode);

        $existing = Absensi::where('kode', $request->kode)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($existing) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan sudah absen hari ini',
                ], 422);
            }
            return redirect()->back()->with('error', 'Karyawan sudah absen hari ini')->withInput();
        }

        Absensi::create([
            'tanggal' => $request->tanggal,
            'kode' => $request->kode,
            'nama' => $karyawan ? $karyawan->nama : '',
            'masuk' => $request->masuk,
            'pulang' => null,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Absen masuk berhasil dicatat',
            ]);
        }

        return redirect()->route('absensi.index')->with('success', 'Absen masuk berhasil dicatat');
    }

    public function show($id)
    {
        $absensi = Absensi::findOrFail($id);

        if (request()->ajax()) {
            return response()->json($absensi);
        }

        return view('tools.absensi.show', compact('absensi'));
    }

    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $karyawanList = Karyawan::orderBy('nama')->get();
        return view('tools.absensi.edit', compact('absensi', 'karyawanList'));
    }

    public function update(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);

        if ($request->has('pulang')) {
            $absensi->pulang = $request->pulang;
            $absensi->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Absen pulang berhasil dicatat',
                ]);
            }

            return redirect()->route('absensi.index')->with('success', 'Absen pulang berhasil dicatat');
        }

        $request->validate([
            'masuk' => 'nullable|date_format:H:i',
            'pulang' => 'nullable|date_format:H:i',
            'keterangan' => 'nullable|string',
        ]);

        $absensi->update($request->only(['masuk', 'pulang', 'keterangan']));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil diupdate',
            ]);
        }

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil diupdate');
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Absensi berhasil dihapus']);
        }

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dihapus');
    }
}
