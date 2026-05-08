<?php

namespace App\Models;



class DetailJasa extends TokoModel
{
    protected $table = 'detailjasa';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'kode_barang',
        'nama_barang',
        'qty',
        'satuan',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
