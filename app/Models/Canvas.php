<?php

namespace App\Models;



class Canvas extends TokoModel
{
    protected $table = 'canvas';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'kd_sales',
        'nm_sales',
        'tanggal',
        'tgl_plg',
        'tuj_area',
        'no_kendaraan',
        'jenis_kendaraan',
        'jumlah',
        'operator',
        'status',
        'supir',
    ];

    public function sales(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Sales::class, 'kd_sales', 'kode');
    }
}
