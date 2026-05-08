<?php

namespace App\Models;



class Pelanggan extends TokoModel
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'max_piutang',
        'saldo_piutang',
        'password',
        'area',
        'instansi',
        'pekerjaan',
        'email',
        'tgllahir',
        'telp',
        'tampil',
        'tgl_lahir',
        'foto',
        'kota',
        'rayon',
        'diskn_penjualan',
        'persen_shu',
        'sales',
        'nonpwp',
        'nofax',
        'kdgrouphrg',
        'nama_toko',
        'saldo_tabungan',
        'pelanggan_kena_pajak',
        'blokir_piutang_hari',
    ];

    public function areaRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Area::class, 'area', 'kode');
    }

    public function instansiRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Instansi::class, 'instansi', 'kode');
    }

    public function salesRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Sales::class, 'sales', 'kode');
    }

    public function kotaRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota', 'kode');
    }

    public function rayonRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Rayon::class, 'rayon', 'kode');
    }

    public function groupHrg(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(GrouphrgPelanggan::class, 'kdgrouphrg', 'kode');
    }

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Penjualan::class, 'pelanggan', 'kode');
    }

    public function piutang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Piutang::class, 'pelanggan', 'kode');
    }

    public function tabungan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tabungan::class, 'pelanggan', 'kode');
    }
}
