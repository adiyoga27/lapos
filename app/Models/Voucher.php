<?php

namespace App\Models;



class Voucher extends TokoModel
{
    protected $table = 'voucher';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal_mulai',
        'tanggal_expired',
        'saldo',
    ];
}
