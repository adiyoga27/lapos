<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Kas;
use App\Models\Bank;
use Illuminate\Http\Request;

class KasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Kas::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        $bank = Bank::orderBy('kode')->get();

        return view('master.kas.index', compact('data', 'search', 'bank'));
    }

    public function create()
    {
        return view('master.kas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:kas,kode',
            'nama' => 'nullable|string|max:50',
            'saldo' => 'nullable|numeric',
            'jenis' => 'nullable|string|max:25',
        ]);

        Kas::create($request->all());

        return redirect()->route('kas.index')
            ->with('success', 'Kas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Kas::findOrFail($id);
        return view('master.kas.show', compact('item'));
    }

    public function edit($id)
    {
        $kas = Kas::findOrFail($id);
        return view('master.kas.edit', compact('kas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:kas,kode,' . $id . ',kode',
            'nama' => 'nullable|string|max:50',
            'saldo' => 'nullable|numeric',
            'jenis' => 'nullable|string|max:25',
        ]);

        $kas = Kas::findOrFail($id);
        $kas->update($request->all());

        return redirect()->route('kas.index')
            ->with('success', 'Kas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kas::findOrFail($id)->delete();

        return redirect()->route('kas.index')
            ->with('success', 'Kas berhasil dihapus.');
    }
}
