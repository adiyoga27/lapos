<?php

namespace App\Models;



class Bank extends TokoModel
{
    protected $table = 'bank';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'beban',
    ];
}
