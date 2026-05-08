<?php

namespace App\Models;



class Penjualan extends TokoModel
{
    protected $table = 'penjualan';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'pelanggan',
        'nama_pelanggan',
        'alamat_pelanggan',
        'member',
        'kode_kas',
        'keterangan',
        'angsuran',
        'subtotal',
        'diskon',
        'diskon_rupiah',
        'tax',
        'tax_rupiah',
        'jumlah',
        'bayar',
        'kembali',
        'operator',
        'point_penjualan',
        'jt',
        'lunas',
        'visa',
        'nomor_visa',
        'nama_visa',
        'jenis',
        'piutang',
        'po',
        'receive',
        'pr',
    ];

    public function pelangganRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan', 'kode');
    }

    public function kas(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kas::class, 'kode_kas', 'kode');
    }

    public function itemPenjualan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemPenjualan::class, 'kode', 'kode');
    }

    public function subItemPenjualan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubItemPenjualan::class, 'no_faktur', 'kode');
    }

    public function piutang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Piutang::class, 'kode_penjualan', 'kode');
    }

    public function pembayaranAngsuran(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PembayaranAngsuran::class, 'kode_faktur', 'kode');
    }
}
