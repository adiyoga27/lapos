<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\LevelPermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $levels = Level::orderBy('kode')->get();
        return view('master.permission.index', compact('levels'));
    }

    public function edit($id)
    {
        $level = Level::findOrFail($id);
        $permissions = $level->getPermissionList();

        $menuItems = [
            'dashboard' => ['label' => 'Dashboard', 'group' => 'Umum'],
            'barang' => ['label' => 'Barang', 'group' => 'Data Master'],
            'jasa' => ['label' => 'Jasa', 'group' => 'Data Master'],
            'kas' => ['label' => 'KAS', 'group' => 'Data Master'],
            'biaya' => ['label' => 'Biaya', 'group' => 'Data Master'],
            'pelanggan' => ['label' => 'Data Pelanggan', 'group' => 'Pelanggan'],
            'member' => ['label' => 'Data Member', 'group' => 'Pelanggan'],
            'supplier' => ['label' => 'Supplier', 'group' => 'Data Master'],
            'karyawan' => ['label' => 'Karyawan', 'group' => 'Data Master'],
            'kategori' => ['label' => 'Kategori', 'group' => 'Lainnya'],
            'golongan' => ['label' => 'Golongan', 'group' => 'Lainnya'],
            'sales' => ['label' => 'Sales', 'group' => 'Lainnya'],
            'area' => ['label' => 'Area', 'group' => 'Lainnya'],
            'kota' => ['label' => 'Kota', 'group' => 'Lainnya'],
            'ukuran' => ['label' => 'Ukuran', 'group' => 'Lainnya'],
            'warna' => ['label' => 'Warna', 'group' => 'Lainnya'],
            'satuan' => ['label' => 'Satuan', 'group' => 'Lainnya'],
            'pajak' => ['label' => 'Pajak', 'group' => 'Lainnya'],
            'level' => ['label' => 'Level Harga', 'group' => 'Lainnya'],
            'bank' => ['label' => 'Bank', 'group' => 'Lainnya'],
            'pembelian' => ['label' => 'Pembelian', 'group' => 'Transaksi'],
            'penjualan' => ['label' => 'Penjualan', 'group' => 'Transaksi'],
            'return_pembelian' => ['label' => 'Return Pembelian', 'group' => 'Transaksi'],
            'return_penjualan' => ['label' => 'Return Penjualan', 'group' => 'Transaksi'],
            'hutang' => ['label' => 'Bayar Hutang', 'group' => 'Hutang Piutang'],
            'piutang' => ['label' => 'Piutang Pelanggan', 'group' => 'Hutang Piutang'],
            'pemasukan' => ['label' => 'Pemasukan', 'group' => 'Back Office'],
            'pengeluaran' => ['label' => 'Pengeluaran', 'group' => 'Back Office'],
            'mutasikas' => ['label' => 'Mutasi Kas', 'group' => 'Back Office'],
            'absensi' => ['label' => 'Absensi', 'group' => 'Back Office'],
            'voucher' => ['label' => 'Tukar Point', 'group' => 'Back Office'],
            'laporan_penjualan' => ['label' => 'Laporan Penjualan', 'group' => 'Laporan'],
            'laporan_pembelian' => ['label' => 'Laporan Pembelian', 'group' => 'Laporan'],
            'laporan_stok' => ['label' => 'Laporan Stok', 'group' => 'Laporan'],
            'laporan_laba_rugi' => ['label' => 'Laporan Laba Rugi', 'group' => 'Laporan'],
            'laporan_kas' => ['label' => 'Laporan Kas', 'group' => 'Laporan'],
            'laporan_hutang_piutang' => ['label' => 'Laporan Hutang Piutang', 'group' => 'Laporan'],
        ];

        return view('master.permission.edit', compact('level', 'permissions', 'menuItems'));
    }

    public function update(Request $request, $id)
    {
        $level = Level::findOrFail($id);

        LevelPermission::where('level_kode', $level->kode)->delete();

        $permissions = $request->input('permissions', []);
        foreach ($permissions as $perm) {
            LevelPermission::create([
                'level_kode' => $level->kode,
                'permission' => $perm,
            ]);
        }

        return redirect()->route('permission.index')
            ->with('success', 'Permission untuk Level "' . $level->nama . '" berhasil diperbarui.');
    }
}