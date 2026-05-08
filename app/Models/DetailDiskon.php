<?php

namespace App\Models;



class DetailDiskon extends TokoModel
{
    protected $table = 'detail_diskon';
    public $timestamps = false;

    protected $fillable = [
        'kodebarang',
        'qtyjual',
        'jumdiskon',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kodebarang', 'kode');
    }
}
