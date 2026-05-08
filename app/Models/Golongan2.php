<?php

namespace App\Models;



class Golongan2 extends TokoModel
{
    protected $table = 'golongan2';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kategori',
        'golongan',
        'golongan1',
        'kode',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barang::class, 'subgolongan2', 'kode');
    }
}
