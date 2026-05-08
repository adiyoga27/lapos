<?php

namespace App\Models;



class AturNota extends TokoModel
{
    protected $table = 'atur_nota';
    public $timestamps = false;

    protected $fillable = [
        'item',
        'posisi',
    ];
}
