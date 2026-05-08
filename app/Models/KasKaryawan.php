<?php

namespace App\Models;



class KasKaryawan extends TokoModel
{
    protected $table = 'kaskaryawan';
    public $timestamps = false;

    protected $fillable = [
        'pr',
        'kodekas',
        'saldo',
    ];

    public function karyawan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'pr', 'kode');
    }

    public function kas(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kas::class, 'kodekas', 'kode');
    }
}
