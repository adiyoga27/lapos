<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Ukuran;
use Illuminate\Http\Request;

class UkuranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Ukuran::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.ukuran.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.ukuran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:ukuran,kode',
        ]);

        Ukuran::create($request->all());

        return redirect()->route('ukuran.index')
            ->with('success', 'Ukuran berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Ukuran::findOrFail($id);
        return view('master.ukuran.show', compact('item'));
    }

    public function edit($id)
    {
        $ukuran = Ukuran::findOrFail($id);
        return view('master.ukuran.edit', compact('ukuran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:ukuran,kode,' . $id . ',kode',
        ]);

        $ukuran = Ukuran::findOrFail($id);
        $ukuran->update($request->all());

        return redirect()->route('ukuran.index')
            ->with('success', 'Ukuran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Ukuran::findOrFail($id)->delete();

        return redirect()->route('ukuran.index')
            ->with('success', 'Ukuran berhasil dihapus.');
    }
}
