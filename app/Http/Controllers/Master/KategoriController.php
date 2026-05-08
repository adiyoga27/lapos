<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Kategori::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.kategori.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:kategori,kode',
            'point_member' => 'nullable|string|max:5',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Kategori::findOrFail($id);
        return view('master.kategori.show', compact('item'));
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('master.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:kategori,kode,' . $id . ',kode',
            'point_member' => 'nullable|string|max:5',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
