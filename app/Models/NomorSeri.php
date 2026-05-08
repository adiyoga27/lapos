<?php

namespace App\Models;



class NomorSeri extends TokoModel
{
    protected $table = 'nomor_seri';
    public $timestamps = false;

    protected $fillable = [
        'kode_barang',
        'nomor_seri',
        'status',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
