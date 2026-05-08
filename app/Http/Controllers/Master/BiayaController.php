<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Biaya;
use Illuminate\Http\Request;

class BiayaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Biaya::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.biaya.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.biaya.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:biaya,kode',
            'nama' => 'nullable|string|max:100',
        ]);

        Biaya::create($request->all());

        return redirect()->route('biaya.index')
            ->with('success', 'Biaya berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Biaya::findOrFail($id);
        return view('master.biaya.show', compact('item'));
    }

    public function edit($id)
    {
        $biaya = Biaya::findOrFail($id);
        return view('master.biaya.edit', compact('biaya'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:biaya,kode,' . $id . ',kode',
            'nama' => 'nullable|string|max:100',
        ]);

        $biaya = Biaya::findOrFail($id);
        $biaya->update($request->all());

        return redirect()->route('biaya.index')
            ->with('success', 'Biaya berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Biaya::findOrFail($id)->delete();

        return redirect()->route('biaya.index')
            ->with('success', 'Biaya berhasil dihapus.');
    }
}
