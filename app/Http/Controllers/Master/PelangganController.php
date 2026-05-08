<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Pelanggan::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.pelanggan.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:pelanggan,kode',
            'nama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:50',
            'kota' => 'nullable|string|max:50',
            'rayon' => 'nullable|string|max:50',
            'area' => 'nullable|string|max:50',
            'sales' => 'nullable|string|max:50',
            'kode_group' => 'nullable|string|max:10',
            'persen_shu' => 'nullable|numeric',
            'saldo_piutang' => 'nullable|numeric',
            'max_piutang' => 'nullable|numeric',
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Pelanggan::with(['areaRef', 'salesRef', 'kotaRef', 'rayonRef'])->findOrFail($id);
        return view('master.pelanggan.show', compact('item'));
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('master.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:pelanggan,kode,' . $id . ',kode',
            'nama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:50',
            'kota' => 'nullable|string|max:50',
            'rayon' => 'nullable|string|max:50',
            'area' => 'nullable|string|max:50',
            'sales' => 'nullable|string|max:50',
            'kode_group' => 'nullable|string|max:10',
            'persen_shu' => 'nullable|numeric',
            'saldo_piutang' => 'nullable|numeric',
            'max_piutang' => 'nullable|numeric',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pelanggan::findOrFail($id)->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
