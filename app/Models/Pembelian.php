<?php

namespace App\Models;



class Pembelian extends TokoModel
{
    protected $table = 'pembelian';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'supplier',
        'kode_kas',
        'keterangan',
        'diskon',
        'tax',
        'jumlah',
        'operator',
        'jt',
        'lunas',
        'visa',
        'nomor_visa',
        'nama_visa',
        'hutang',
        'po',
        'receive',
        'jasakirim',
        'biayakirim',
        'lokasistok',
        'pr',
    ];

    public function supplierRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'kode');
    }

    public function kas(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kas::class, 'kode_kas', 'kode');
    }

    public function itemPembelian(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemPembelian::class, 'kode', 'kode');
    }

    public function itemHutang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemHutang::class, 'kode_pembelian', 'kode');
    }
}
