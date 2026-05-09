<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Golongan;
use App\Models\SatuanJual;
use App\Models\Ukuran;
use App\Models\Warna;
use App\Models\Supplier;
use App\Models\Pajak;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $data = Barang::with(['kategoriRef', 'supplierRef', 'golonganRef', 'golongan1Ref', 'golongan2Ref', 'ukuranRel', 'warnaRel'])
            ->when($search, function ($q) use ($search) {
                return $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhere('kode_barcode', 'like', "%{$search}%")
                    ->orWhere('supplier', 'like', "%{$search}%");
            })->orderBy('kode')->get();

        return view('master.barang.index', compact('data', 'search'));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('kode')->get();
        $golongan = Golongan::orderBy('kode')->get();
        $satuan = SatuanJual::orderBy('nama')->get();
        $ukuran = Ukuran::orderBy('kode')->get();
        $warna = Warna::orderBy('kode')->get();
        $supplier = Supplier::orderBy('kode')->get();
        $pajak = Pajak::orderBy('kode')->get();
        return view('master.barang.create', compact('kategori', 'golongan', 'satuan', 'ukuran', 'warna', 'supplier', 'pajak'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:25|unique:barang,kode',
            'nama' => 'nullable|string|max:50',
            'kategori' => 'nullable|string|max:50',
            'satuanbeli' => 'nullable|string|max:25',
            'satuan' => 'nullable|string|max:25',
            'satuan2' => 'nullable|string|max:25',
            'satuan3' => 'nullable|string|max:25',
            'isi' => 'nullable|numeric',
            'isi2' => 'nullable|numeric',
            'isi3' => 'nullable|numeric',
            'hpp' => 'nullable|numeric',
            'harga_toko' => 'nullable|numeric',
            'harga_toko2' => 'nullable|numeric',
            'harga_toko3' => 'nullable|numeric',
            'harga_partai' => 'nullable|numeric',
            'harga_partai2' => 'nullable|numeric',
            'harga_partai3' => 'nullable|numeric',
            'harga_cabang' => 'nullable|numeric',
            'harga_cabang2' => 'nullable|numeric',
            'harga_cabang3' => 'nullable|numeric',
            'margin_toko' => 'nullable|numeric',
            'margin_toko2' => 'nullable|numeric',
            'margin_toko3' => 'nullable|numeric',
            'margin_partai' => 'nullable|numeric',
            'margin_partai2' => 'nullable|numeric',
            'margin_partai3' => 'nullable|numeric',
            'margin_cabang' => 'nullable|numeric',
            'harga_member' => 'nullable|numeric',
            'harga_karyawan' => 'nullable|numeric',
            'toko' => 'nullable|numeric',
            'gudang' => 'nullable|numeric',
            'toko_rusak' => 'nullable|numeric',
            'gudang_rusak' => 'nullable|numeric',
            'diskon' => 'nullable|numeric',
            'diskon_toko' => 'nullable|numeric',
            'diskon_partai' => 'nullable|numeric',
            'point' => 'nullable|numeric',
            'point_m' => 'nullable|numeric',
            'stokmin' => 'nullable|numeric',
            'stokmax' => 'nullable|numeric',
            'stokmin_gudang' => 'nullable|numeric',
            'stokmax_gudang' => 'nullable|numeric',
            'kode_barcode' => 'nullable|string|max:25',
            'kode_barcode2' => 'nullable|string|max:25',
            'kode_barcode3' => 'nullable|string|max:25',
            'ukuran' => 'nullable|string|max:15',
            'warna' => 'nullable|string|max:25',
            'supplier' => 'nullable|string|max:15',
            'pajak' => 'nullable|string|max:15',
            'merk' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:50',
            'nama2' => 'nullable|string|max:50',
            'nama3' => 'nullable|string|max:50',
            'tipe_disc_member' => 'nullable|string|max:5',
            'jum_diskon_member' => 'nullable|numeric',
            'jum_komisi_sales' => 'nullable|numeric',
            'expired' => 'nullable|date',
            'ket' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'gambar2' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['gambar', 'gambar2']);
        $data['nol_price'] = $request->has('nol_price') ? 1 : 0;
        $data['nol_price_diskon'] = $request->has('nol_price_diskon') ? 1 : 0;
        $data['ada_expired_date'] = $request->has('ada_expired_date') ? 1 : 0;
        $data['paket'] = $request->has('paket') ? 1 : 0;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_1.' . $file->getClientOriginalExtension();
            $file->move(public_path('build/images/barang'), $filename);
            $data['gambar'] = $filename;
        }
        if ($request->hasFile('gambar2')) {
            $file = $request->file('gambar2');
            $filename = time() . '_2.' . $file->getClientOriginalExtension();
            $file->move(public_path('build/images/barang'), $filename);
            $data['gambar2'] = $filename;
        }

        Barang::create($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $barang = Barang::with(['kategoriRef', 'golonganRef', 'golongan1Ref', 'golongan2Ref', 'supplierRef', 'ukuranRel', 'warnaRel'])->findOrFail($id);
        return view('master.barang.show', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = Kategori::orderBy('kode')->get();
        $golongan = Golongan::orderBy('kode')->get();
        $satuan = SatuanJual::orderBy('nama')->get();
        $ukuran = Ukuran::orderBy('kode')->get();
        $warna = Warna::orderBy('kode')->get();
        $supplier = Supplier::orderBy('kode')->get();
        $pajak = Pajak::orderBy('kode')->get();
        return view('master.barang.edit', compact('barang', 'kategori', 'golongan', 'satuan', 'ukuran', 'warna', 'supplier', 'pajak'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:25|unique:barang,kode,' . $id . ',kode',
            'nama' => 'nullable|string|max:50',
            'kategori' => 'nullable|string|max:50',
            'satuanbeli' => 'nullable|string|max:25',
            'satuan' => 'nullable|string|max:25',
            'satuan2' => 'nullable|string|max:25',
            'satuan3' => 'nullable|string|max:25',
            'isi' => 'nullable|numeric',
            'isi2' => 'nullable|numeric',
            'isi3' => 'nullable|numeric',
            'hpp' => 'nullable|numeric',
            'harga_toko' => 'nullable|numeric',
            'harga_toko2' => 'nullable|numeric',
            'harga_toko3' => 'nullable|numeric',
            'harga_partai' => 'nullable|numeric',
            'harga_partai2' => 'nullable|numeric',
            'harga_partai3' => 'nullable|numeric',
            'harga_cabang' => 'nullable|numeric',
            'harga_cabang2' => 'nullable|numeric',
            'harga_cabang3' => 'nullable|numeric',
            'margin_toko' => 'nullable|numeric',
            'margin_toko2' => 'nullable|numeric',
            'margin_toko3' => 'nullable|numeric',
            'margin_partai' => 'nullable|numeric',
            'margin_partai2' => 'nullable|numeric',
            'margin_partai3' => 'nullable|numeric',
            'margin_cabang' => 'nullable|numeric',
            'harga_member' => 'nullable|numeric',
            'harga_karyawan' => 'nullable|numeric',
            'toko' => 'nullable|numeric',
            'gudang' => 'nullable|numeric',
            'toko_rusak' => 'nullable|numeric',
            'gudang_rusak' => 'nullable|numeric',
            'diskon' => 'nullable|numeric',
            'diskon_toko' => 'nullable|numeric',
            'diskon_partai' => 'nullable|numeric',
            'point' => 'nullable|numeric',
            'point_m' => 'nullable|numeric',
            'stokmin' => 'nullable|numeric',
            'stokmax' => 'nullable|numeric',
            'stokmin_gudang' => 'nullable|numeric',
            'stokmax_gudang' => 'nullable|numeric',
            'kode_barcode' => 'nullable|string|max:25',
            'kode_barcode2' => 'nullable|string|max:25',
            'kode_barcode3' => 'nullable|string|max:25',
            'ukuran' => 'nullable|string|max:15',
            'warna' => 'nullable|string|max:25',
            'supplier' => 'nullable|string|max:15',
            'pajak' => 'nullable|string|max:15',
            'merk' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:50',
            'nama2' => 'nullable|string|max:50',
            'nama3' => 'nullable|string|max:50',
            'tipe_disc_member' => 'nullable|string|max:5',
            'jum_diskon_member' => 'nullable|numeric',
            'jum_komisi_sales' => 'nullable|numeric',
            'expired' => 'nullable|date',
            'ket' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'gambar2' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['gambar', 'gambar2']);
        $data['nol_price'] = $request->has('nol_price') ? 1 : 0;
        $data['nol_price_diskon'] = $request->has('nol_price_diskon') ? 1 : 0;
        $data['ada_expired_date'] = $request->has('ada_expired_date') ? 1 : 0;
        $data['paket'] = $request->has('paket') ? 1 : 0;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_1.' . $file->getClientOriginalExtension();
            $file->move(public_path('build/images/barang'), $filename);
            $data['gambar'] = $filename;
        }
        if ($request->hasFile('gambar2')) {
            $file = $request->file('gambar2');
            $filename = time() . '_2.' . $file->getClientOriginalExtension();
            $file->move(public_path('build/images/barang'), $filename);
            $data['gambar2'] = $filename;
        }

        $barang->update($data);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
