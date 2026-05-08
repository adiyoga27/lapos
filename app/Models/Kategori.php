<?php

namespace App\Models;



class Kategori extends TokoModel
{
    protected $table = 'kategori';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'point_member',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barang::class, 'kategori', 'kode');
    }
}
