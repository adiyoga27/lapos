<?php

namespace App\Models;



class Produksi extends TokoModel
{
    protected $table = 'produksi';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'keterangan',
        'kode_kas',
        'operator',
        'jumlah',
    ];

    public function kas(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kas::class, 'kode_kas', 'kode');
    }
}
