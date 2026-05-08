<?php

namespace App\Models;



class ItemPiutang extends TokoModel
{
    protected $table = 'itempiutang';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'kode_piutang',
        'kode_penjualan',
        'tgl_penjualan',
        'jum_penjualan',
        'jum_pembayaran',
        'jum_return',
    ];

    public function piutang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Piutang::class, 'kode_piutang', 'kode');
    }

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'kode_penjualan', 'kode');
    }
}
