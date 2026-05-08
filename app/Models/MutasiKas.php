<?php

namespace App\Models;



class MutasiKas extends TokoModel
{
    protected $table = 'mutasikas';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'dari',
        'ke',
        'jumlah',
        'keterangan',
        'operator',
    ];

    public function kasDari(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kas::class, 'dari', 'kode');
    }

    public function kasKe(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kas::class, 'ke', 'kode');
    }
}
