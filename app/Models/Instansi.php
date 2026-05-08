<?php

namespace App\Models;



class Instansi extends TokoModel
{
    protected $table = 'instansi';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
    ];

    public function pelanggan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pelanggan::class, 'instansi', 'kode');
    }
}
