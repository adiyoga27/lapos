<?php

namespace App\Models;



class Type extends TokoModel
{
    protected $table = 'type';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barang::class, 'type', 'kode');
    }
}
