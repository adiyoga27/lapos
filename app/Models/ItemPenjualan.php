<?php

namespace App\Models;



class ItemPenjualan extends TokoModel
{
    protected $table = 'itempenjualan';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'kode_barang',
        'nama_barang',
        'satuan',
        'qty',
        'harga',
        'subtotal',
        'isi',
        'satuan_isi',
        'harga_isi',
        'diskon',
        'diskon2',
        'hpp',
        'harga_awal',
        'harga_awal2',
        'harga_awal3',
        'poin',
        'sn',
        'diskon_tambahan',
    ];

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'kode', 'kode');
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
