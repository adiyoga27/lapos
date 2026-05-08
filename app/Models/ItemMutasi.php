<?php

namespace App\Models;



class ItemMutasi extends TokoModel
{
    protected $table = 'itemmutasi';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'kode_barang',
        'nama_barang',
        'satuan',
        'qty',
        'lokasistok',
    ];

    public function mutasi(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MutasiBarang::class, 'kode', 'kode');
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
