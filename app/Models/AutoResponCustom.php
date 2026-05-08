<?php

namespace App\Models;



class AutoResponCustom extends TokoModel
{
    protected $table = 'auto_respon_custom';
    protected $primaryKey = 'pesan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'pesan',
        'balasan',
    ];
}
