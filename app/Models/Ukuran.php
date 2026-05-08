<?php

namespace App\Models;



class Ukuran extends TokoModel
{
    protected $table = 'ukuran';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barang::class, 'ukuran', 'kode');
    }
}
