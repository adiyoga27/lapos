<?php

namespace App\Models;



class TukangJahit extends TokoModel
{
    protected $table = 'tukangjahit';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'telp',
    ];
}
