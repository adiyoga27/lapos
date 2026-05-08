<?php

namespace App\Models;



class ExpiredBarang extends TokoModel
{
    protected $table = 'expired_barang';
    public $timestamps = false;

    protected $fillable = [
        'cek',
        'kode_barang',
        'qty',
        'tgl_expired',
        'tgl_input',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
