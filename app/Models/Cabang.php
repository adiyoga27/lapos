<?php

namespace App\Models;



class Cabang extends TokoModel
{
    protected $table = 'cabang';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'max_piutang',
        'saldo_piutang',
        'nonpwp',
        'pelanggan_kena_pajak',
    ];
}
