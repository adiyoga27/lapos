<?php

namespace App\Models;



class Supplier extends TokoModel
{
    protected $table = 'supplier';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'saldo_piutang',
        'tgl_saldo',
        'nomor',
        'telp',
        'fax',
        'email',
        'no_npwp',
        'tampil',
        'kdgrouphrg',
        'kota',
        'alamat2',
        'contact',
    ];

    public function kotaRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota', 'kode');
    }

    public function groupHrg(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(GrouphrgSupplier::class, 'kdgrouphrg', 'kode');
    }

    public function pembelian(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pembelian::class, 'supplier', 'kode');
    }

    public function hutang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Hutang::class, 'supplier', 'kode');
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Barang::class, 'supplier', 'kode');
    }

    public function salesSupplier(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesSupplier::class, 'kode_supplier', 'kode');
    }
}
