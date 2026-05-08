<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Level::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.level.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.level.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:level,kode',
            'nama' => 'nullable|string|max:50',
        ]);

        Level::create($request->all());

        return redirect()->route('level.index')
            ->with('success', 'Level berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Level::findOrFail($id);
        return view('master.level.show', compact('item'));
    }

    public function edit($id)
    {
        $level = Level::findOrFail($id);
        return view('master.level.edit', compact('level'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:level,kode,' . $id . ',kode',
            'nama' => 'nullable|string|max:50',
        ]);

        $level = Level::findOrFail($id);
        $level->update($request->all());

        return redirect()->route('level.index')
            ->with('success', 'Level berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Level::findOrFail($id)->delete();

        return redirect()->route('level.index')
            ->with('success', 'Level berhasil dihapus.');
    }
}
