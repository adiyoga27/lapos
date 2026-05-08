<?php

namespace App\Models;



class Pajak extends TokoModel
{
    protected $table = 'pajak';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'nilai',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barang::class, 'pajak', 'kode');
    }
}
