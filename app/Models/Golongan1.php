<?php

namespace App\Models;



class Golongan1 extends TokoModel
{
    protected $table = 'golongan1';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kategori',
        'golongan',
        'kode',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barang::class, 'subgolongan1', 'kode');
    }

    public function golonganRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Golongan::class, 'golongan', 'kode');
    }

    public function golongan2(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Golongan2::class, 'golongan1', 'kode');
    }
}
