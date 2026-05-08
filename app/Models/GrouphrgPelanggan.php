<?php

namespace App\Models;



class GrouphrgPelanggan extends TokoModel
{
    protected $table = 'grouphrgpelanggan';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
    ];

    public function hrgPerGroup(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(HrgPerGroup::class, 'kdgrouphrg', 'kode');
    }

    public function pelanggan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pelanggan::class, 'kdgrouphrg', 'kode');
    }
}
