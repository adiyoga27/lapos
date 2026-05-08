<?php

namespace App\Models;



class SetPointMember extends TokoModel
{
    protected $table = 'set_point_member';
    public $timestamps = false;

    protected $fillable = [
        'jumlah1',
        'point1',
        'jumlah2',
        'point2',
        'jumlah3',
        'point3',
        'jumlah4',
        'point4',
        'jumlah5',
        'point5',
        'jumlah6',
        'point6',
        'jumlah7',
        'point7',
        'jumlah8',
        'point8',
        'berlakukelipatan',
    ];
}
