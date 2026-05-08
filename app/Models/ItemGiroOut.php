<?php

namespace App\Models;



class ItemGiroOut extends TokoModel
{
    protected $table = 'itemgiroout';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_giro',
        'kode_hutang',
        'tgl_hutang',
        'jum_hutang',
        'jum_bayar',
        'kode',
    ];
}
