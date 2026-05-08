<?php

namespace App\Models;



class SatuanJual extends TokoModel
{
    protected $table = 'satuanjual';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nama',
    ];

    public function getKeyName(): string
    {
        return 'nama';
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barang::class, 'satuan', 'nama');
    }
}
