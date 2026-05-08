<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('kode', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $today = date('Y-m-d');
            if ($request->status === 'aktif') {
                $query->where('tanggal_expired', '>=', $today)
                      ->where('tanggal_mulai', '<=', $today);
            } elseif ($request->status === 'expired') {
                $query->where('tanggal_expired', '<', $today);
            } elseif ($request->status === 'upcoming') {
                $query->where('tanggal_mulai', '>', $today);
            }
        }

        $voucher = $query->orderBy('tanggal_mulai', 'desc')->paginate(20);

        if ($request->ajax()) {
            return response()->json($voucher);
        }

        return view('tools.voucher.index', compact('voucher'));
    }

    public function create()
    {
        return view('tools.voucher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|unique:voucher,kode',
            'tanggal_mulai' => 'required|date',
            'tanggal_expired' => 'required|date|after_or_equal:tanggal_mulai',
            'saldo' => 'required|numeric|min:0',
        ]);

        Voucher::create([
            'kode' => $request->kode,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_expired' => $request->tanggal_expired,
            'saldo' => $request->saldo,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Voucher berhasil dibuat',
            ]);
        }

        return redirect()->route('voucher.index')->with('success', 'Voucher berhasil dibuat');
    }

    public function show($kode)
    {
        $voucher = Voucher::findOrFail($kode);

        if (request()->ajax()) {
            return response()->json($voucher);
        }

        return view('tools.voucher.show', compact('voucher'));
    }

    public function edit($kode)
    {
        $voucher = Voucher::findOrFail($kode);
        return view('tools.voucher.edit', compact('voucher'));
    }

    public function update(Request $request, $kode)
    {
        $voucher = Voucher::findOrFail($kode);

        $request->validate([
            'kode' => 'required|string|unique:voucher,kode,' . $kode . ',kode',
            'tanggal_mulai' => 'required|date',
            'tanggal_expired' => 'required|date|after_or_equal:tanggal_mulai',
            'saldo' => 'required|numeric|min:0',
        ]);

        $voucher->update([
            'kode' => $request->kode,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_expired' => $request->tanggal_expired,
            'saldo' => $request->saldo,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Voucher berhasil diupdate',
            ]);
        }

        return redirect()->route('voucher.index')->with('success', 'Voucher berhasil diupdate');
    }

    public function destroy($kode)
    {
        $voucher = Voucher::findOrFail($kode);
        $voucher->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Voucher berhasil dihapus']);
        }

        return redirect()->route('voucher.index')->with('success', 'Voucher berhasil dihapus');
    }
}
