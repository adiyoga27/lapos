<?php

namespace App\Models;



class SetupPerusahaan extends TokoModel
{
    protected $table = 'setup_perusahaan';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'alamat',
        'telp',
        'fax',
        'kota',
        'propinsi',
        'negara',
        'lokasi',
        'kd_pembelian',
        'kd_return_pembelian',
        'kd_terima_return',
        'kd_penjualan_toko',
        'kd_return_penjualan',
        'kd_pengeluaran',
        'kd_bayar_hutang',
        'kd_bayar_piutang',
        'kd_mutasi_kas',
        'kd_tukar_point',
        'kd_penyesuaian_stok',
        'footer_pembelian',
        'tutup_form_setelah_disimpan',
        'aktivkan_login',
        'id_operator',
        'nama_operator',
        'preview_moda',
        'point_member',
        'jumlah_point_member',
        'clear_point_member',
        'point_komisi_member',
        'clear_point_pelanggan',
        'identitas_cabang',
    ];
}
