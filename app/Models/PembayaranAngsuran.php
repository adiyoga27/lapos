<?php

namespace App\Models;



class PembayaranAngsuran extends TokoModel
{
    protected $table = 'pembayaran_angsuran';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'angsuran_ke',
        'kode_pelanggan',
        'kode_faktur',
        'jumlah',
    ];

    public function pelanggan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'kode_pelanggan', 'kode');
    }

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'kode_faktur', 'kode');
    }
}
