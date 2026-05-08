<?php

namespace App\Models;



class Lokasi extends TokoModel
{
    protected $table = 'lokasi';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barang::class, 'lokasi', 'kode');
    }
}
