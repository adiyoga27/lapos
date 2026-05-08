<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Sales::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.sales.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.sales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:sales,kode',
            'nama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:15',
        ]);

        Sales::create($request->all());

        return redirect()->route('sales.index')
            ->with('success', 'Sales berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Sales::findOrFail($id);
        return view('master.sales.show', compact('item'));
    }

    public function edit($id)
    {
        $sales = Sales::findOrFail($id);
        return view('master.sales.edit', compact('sales'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:sales,kode,' . $id . ',kode',
            'nama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:15',
        ]);

        $sales = Sales::findOrFail($id);
        $sales->update($request->all());

        return redirect()->route('sales.index')
            ->with('success', 'Sales berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Sales::findOrFail($id)->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Sales berhasil dihapus.');
    }
}
