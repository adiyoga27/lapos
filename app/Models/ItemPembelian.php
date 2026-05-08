<?php

namespace App\Models;



class ItemPembelian extends TokoModel
{
    protected $table = 'itempembelian';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'kode_barang',
        'nama_barang',
        'satuan',
        'qty',
        'harga',
        'jumlah',
        'hpp',
        'harga_jual',
        'isi',
        'satuan_isi',
        'hpp_isi',
        'harga_jual_isi',
        'diskon',
        'diskon2',
        'subtotal',
        'lokasistok',
        'harga_toko',
        'harga_partai',
        'harga_cabang',
        'harga_toko2',
        'harga_toko3',
        'harga_partai2',
        'harga_partai3',
        'harga_cabang2',
        'harga_cabang3',
        'expired',
        'no_surat_jalan',
    ];

    public function pembelian(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'kode', 'kode');
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
