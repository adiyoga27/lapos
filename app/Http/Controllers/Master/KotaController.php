<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Kota::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.kota.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.kota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:kota,kode',
            'nama' => 'nullable|string|max:100',
        ]);

        Kota::create($request->all());

        return redirect()->route('kota.index')
            ->with('success', 'Kota berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Kota::findOrFail($id);
        return view('master.kota.show', compact('item'));
    }

    public function edit($id)
    {
        $kota = Kota::findOrFail($id);
        return view('master.kota.edit', compact('kota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:kota,kode,' . $id . ',kode',
            'nama' => 'nullable|string|max:100',
        ]);

        $kota = Kota::findOrFail($id);
        $kota->update($request->all());

        return redirect()->route('kota.index')
            ->with('success', 'Kota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kota::findOrFail($id)->delete();

        return redirect()->route('kota.index')
            ->with('success', 'Kota berhasil dihapus.');
    }
}
