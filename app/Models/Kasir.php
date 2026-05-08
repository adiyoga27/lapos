<?php

namespace App\Models;



class Kasir extends TokoModel
{
    protected $table = 'kasir';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
    ];

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Penjualan::class, 'kode_kasir', 'kode');
    }
}
