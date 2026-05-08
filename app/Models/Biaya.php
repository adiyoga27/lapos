<?php

namespace App\Models;



class Biaya extends TokoModel
{
    protected $table = 'biaya';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'saldo',
    ];

    public function pemasukan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pemasukan::class, 'kd_biaya', 'kode');
    }
}
