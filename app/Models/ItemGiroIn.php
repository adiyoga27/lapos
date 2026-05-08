<?php

namespace App\Models;



class ItemGiroIn extends TokoModel
{
    protected $table = 'itemgiroin';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_giro',
        'kode_piutang',
        'tgl_piutang',
        'jum_piutang',
        'jum_bayar',
        'jum_return',
        'kode',
    ];
}
