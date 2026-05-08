<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Bank::when($search, function ($q) use ($search) {
            return $q->where('kode', 'like', "%{$search}%");
        })->orderBy('kode')->paginate(15);

        return view('master.bank.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.bank.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:bank,kode',
            'beban' => 'nullable|numeric',
        ]);

        Bank::create($request->all());

        return redirect()->route('bank.index')
            ->with('success', 'Bank berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Bank::findOrFail($id);
        return view('master.bank.show', compact('item'));
    }

    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return view('master.bank.edit', compact('bank'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50|unique:bank,kode,' . $id . ',kode',
            'beban' => 'nullable|numeric',
        ]);

        $bank = Bank::findOrFail($id);
        $bank->update($request->all());

        return redirect()->route('bank.index')
            ->with('success', 'Bank berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Bank::findOrFail($id)->delete();

        return redirect()->route('bank.index')
            ->with('success', 'Bank berhasil dihapus.');
    }
}
