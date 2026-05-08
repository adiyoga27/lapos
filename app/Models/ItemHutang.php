<?php

namespace App\Models;



class ItemHutang extends TokoModel
{
    protected $table = 'itemhutang';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'kode_hutang',
        'kode_pembelian',
        'tgl_pembelian',
        'jum_pembelian',
        'jum_pembayaran',
    ];

    public function hutang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Hutang::class, 'kode_hutang', 'kode');
    }

    public function pembelian(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'kode_pembelian', 'kode');
    }
}
