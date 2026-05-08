<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Warna;
use Illuminate\Http\Request;

class WarnaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Warna::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.warna.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.warna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:warna,kode',
        ]);

        Warna::create($request->all());

        return redirect()->route('warna.index')
            ->with('success', 'Warna berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Warna::findOrFail($id);
        return view('master.warna.show', compact('item'));
    }

    public function edit($id)
    {
        $warna = Warna::findOrFail($id);
        return view('master.warna.edit', compact('warna'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:warna,kode,' . $id . ',kode',
        ]);

        $warna = Warna::findOrFail($id);
        $warna->update($request->all());

        return redirect()->route('warna.index')
            ->with('success', 'Warna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Warna::findOrFail($id)->delete();

        return redirect()->route('warna.index')
            ->with('success', 'Warna berhasil dihapus.');
    }
}
