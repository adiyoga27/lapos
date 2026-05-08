<?php

namespace App\Models;



class Golongan extends TokoModel
{
    protected $table = 'golongan';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kategori',
        'kode',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barang::class, 'golongan', 'kode');
    }

    public function golongan1(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Golongan1::class, 'golongan', 'kode');
    }
}
