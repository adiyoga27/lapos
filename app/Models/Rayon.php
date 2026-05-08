<?php

namespace App\Models;



class Rayon extends TokoModel
{
    protected $table = 'rayon';
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
        return $this->hasMany(Pelanggan::class, 'rayon', 'kode');
    }
}
