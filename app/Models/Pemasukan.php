<?php

namespace App\Models;



class Pemasukan extends TokoModel
{
    protected $table = 'pemasukan';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'kd_biaya',
        'keterangan',
        'kode_kas',
        'jumlah',
        'operator',
        'pr',
    ];

    public function biaya(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Biaya::class, 'kd_biaya', 'kode');
    }

    public function kas(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kas::class, 'kode_kas', 'kode');
    }
}
