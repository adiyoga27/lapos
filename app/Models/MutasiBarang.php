<?php

namespace App\Models;



class MutasiBarang extends TokoModel
{
    protected $table = 'mutasibarang';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'dari',
        'ke',
        'keterangan',
        'operator',
    ];

    public function itemMutasi(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemMutasi::class, 'kode', 'kode');
    }
}
