<?php

namespace App\Models;



class Tabungan extends TokoModel
{
    protected $table = 'tabungan';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'jam',
        'pelanggan',
        'jumlah',
        'jenis',
        'keterangan',
        'kode_kas',
    ];

    public function pelangganRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan', 'kode');
    }
}
