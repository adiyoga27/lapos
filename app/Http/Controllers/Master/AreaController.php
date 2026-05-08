<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Area::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.area.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.area.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:area,kode',
        ]);

        Area::create($request->all());

        return redirect()->route('area.index')
            ->with('success', 'Area berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Area::findOrFail($id);
        return view('master.area.show', compact('item'));
    }

    public function edit($id)
    {
        $area = Area::findOrFail($id);
        return view('master.area.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:area,kode,' . $id . ',kode',
        ]);

        $area = Area::findOrFail($id);
        $area->update($request->all());

        return redirect()->route('area.index')
            ->with('success', 'Area berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Area::findOrFail($id)->delete();

        return redirect()->route('area.index')
            ->with('success', 'Area berhasil dihapus.');
    }
}
