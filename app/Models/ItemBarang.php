<?php

namespace App\Models;



class ItemBarang extends TokoModel
{
    protected $table = 'item_barang';
    public $timestamps = false;

    protected $fillable = [
        'kdbuat',
        'tglbuat',
        'kode',
        'kode_barang',
        'nama_barang',
        'satuan',
        'qty',
        'harga',
        'hpp',
        'harga_jual',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
