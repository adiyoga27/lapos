<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Supplier::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.supplier.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:supplier,kode',
            'nama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'alamat2' => 'nullable|string',
            'telp' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'kota' => 'nullable|string|max:50',
            'no_npwp' => 'nullable|string|max:50',
            'contact' => 'nullable|string|max:100',
            'saldo_piutang' => 'nullable|numeric',
            'tgl_saldo' => 'nullable|date',
        ]);

        Supplier::create($request->all());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Supplier::with('kotaRef')->findOrFail($id);
        return view('master.supplier.show', compact('item'));
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('master.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:supplier,kode,' . $id . ',kode',
            'nama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'alamat2' => 'nullable|string',
            'telp' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'kota' => 'nullable|string|max:50',
            'no_npwp' => 'nullable|string|max:50',
            'contact' => 'nullable|string|max:100',
            'saldo_piutang' => 'nullable|numeric',
            'tgl_saldo' => 'nullable|date',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();

        return redirect()->route('supplier.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
