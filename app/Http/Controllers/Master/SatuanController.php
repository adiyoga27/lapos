<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\SatuanJual;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = SatuanJual::when($search, function ($q) use ($search) {
            return $q->where('nama', 'like', "%{$search}%");
        })->orderBy('nama')->paginate(15);

        return view('master.satuan.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.satuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:25|unique:satuanjual,nama',
        ]);

        SatuanJual::create($request->all());

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = SatuanJual::where('nama', $id)->firstOrFail();
        return view('master.satuan.show', compact('item'));
    }

    public function edit($id)
    {
        $satuan = SatuanJual::where('nama', $id)->firstOrFail();
        return view('master.satuan.edit', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:25|unique:satuanjual,nama,' . $id . ',nama',
        ]);

        $satuan = SatuanJual::where('nama', $id)->firstOrFail();
        $satuan->update($request->all());

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        SatuanJual::where('nama', $id)->firstOrFail()->delete();

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil dihapus.');
    }
}
