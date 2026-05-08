<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Karyawan::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.karyawan.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:karyawan,kode',
            'nama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'shif' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Karyawan::with('levelRef')->findOrFail($id);
        return view('master.karyawan.show', compact('item'));
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('master.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:karyawan,kode,' . $id . ',kode',
            'nama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'shif' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($request->all());

        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Karyawan::findOrFail($id)->delete();

        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
