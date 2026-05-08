<?php

namespace App\Models;



class Kota extends TokoModel
{
    protected $table = 'kota';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
    ];

    public function pelanggan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pelanggan::class, 'kota', 'kode');
    }

    public function supplier(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Supplier::class, 'kota', 'kode');
    }
}
