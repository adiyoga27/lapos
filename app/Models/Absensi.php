<?php

namespace App\Models;



class Absensi extends TokoModel
{
    protected $table = 'absensi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'tanggal',
        'kode',
        'nama',
        'masuk',
        'pulang',
        'keterangan',
    ];
}
