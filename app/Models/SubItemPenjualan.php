<?php

namespace App\Models;



class SubItemPenjualan extends TokoModel
{
    protected $table = 'subitempenjualan';
    public $timestamps = false;

    protected $fillable = [
        'no_faktur',
        'kode_barang',
        'nama_barang',
        'satuan',
        'qty',
        'harga',
        'subtotal',
        'kd_barang',
    ];

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'no_faktur', 'kode');
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
