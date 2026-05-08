<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Golongan::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.golongan.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.golongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:golongan,kode',
            'kategori' => 'nullable|string|max:50',
        ]);

        Golongan::create($request->all());

        return redirect()->route('golongan.index')
            ->with('success', 'Golongan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Golongan::findOrFail($id);
        return view('master.golongan.show', compact('item'));
    }

    public function edit($id)
    {
        $golongan = Golongan::findOrFail($id);
        return view('master.golongan.edit', compact('golongan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:golongan,kode,' . $id . ',kode',
            'kategori' => 'nullable|string|max:50',
        ]);

        $golongan = Golongan::findOrFail($id);
        $golongan->update($request->all());

        return redirect()->route('golongan.index')
            ->with('success', 'Golongan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Golongan::findOrFail($id)->delete();

        return redirect()->route('golongan.index')
            ->with('success', 'Golongan berhasil dihapus.');
    }
}
