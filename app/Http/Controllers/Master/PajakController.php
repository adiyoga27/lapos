<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Pajak;
use Illuminate\Http\Request;

class PajakController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Pajak::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.pajak.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.pajak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:pajak,kode',
            'nama' => 'nullable|string|max:50',
            'nilai' => 'nullable|numeric',
        ]);

        Pajak::create($request->all());

        return redirect()->route('pajak.index')
            ->with('success', 'Pajak berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Pajak::findOrFail($id);
        return view('master.pajak.show', compact('item'));
    }

    public function edit($id)
    {
        $pajak = Pajak::findOrFail($id);
        return view('master.pajak.edit', compact('pajak'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:pajak,kode,' . $id . ',kode',
            'nama' => 'nullable|string|max:50',
            'nilai' => 'nullable|numeric',
        ]);

        $pajak = Pajak::findOrFail($id);
        $pajak->update($request->all());

        return redirect()->route('pajak.index')
            ->with('success', 'Pajak berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pajak::findOrFail($id)->delete();

        return redirect()->route('pajak.index')
            ->with('success', 'Pajak berhasil dihapus.');
    }
}
