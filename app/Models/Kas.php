<?php

namespace App\Models;



class Kas extends TokoModel
{
    protected $table = 'kas';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'saldo',
        'default_toko',
        'default_return_pembelian',
        'default_pembelian',
        'default_pembelian_read_only',
        'default_produksi',
        'default_pengiriman_po',
        'default_pengiriman_po_read_only',
    ];

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Penjualan::class, 'kode_kas', 'kode');
    }

    public function pembelian(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pembelian::class, 'kode_kas', 'kode');
    }

    public function pemasukan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pemasukan::class, 'kode_kas', 'kode');
    }

    public function pengeluaran(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pengeluaran::class, 'kode_kas', 'kode');
    }
}
