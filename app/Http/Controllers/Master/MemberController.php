<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Member::when($search, function ($q) use ($search) {
            return $q->where('id_kartu', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->orderBy('id_kartu')->paginate(15);

        return view('master.member.index', compact('data', 'search'));
    }

    public function create()
    {
        return view('master.member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kartu' => 'required|string|max:50|unique:member,id_kartu',
            'nama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:50',
            'point' => 'nullable|numeric',
            'expired' => 'nullable|date',
        ]);

        Member::create($request->all());

        return redirect()->route('member.index')
            ->with('success', 'Member berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Member::findOrFail($id);
        return view('master.member.show', compact('item'));
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('master.member.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kartu' => 'required|string|max:50|unique:member,id_kartu,' . $id . ',id_kartu',
            'nama' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telp' => 'nullable|string|max:50',
            'point' => 'nullable|numeric',
            'expired' => 'nullable|date',
        ]);

        $member = Member::findOrFail($id);
        $member->update($request->all());

        return redirect()->route('member.index')
            ->with('success', 'Member berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Member::findOrFail($id)->delete();

        return redirect()->route('member.index')
            ->with('success', 'Member berhasil dihapus.');
    }
}
