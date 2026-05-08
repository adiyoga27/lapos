<?php

namespace App\Models;



class Piutang extends TokoModel
{
    protected $table = 'piutang';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'pelanggan',
        'alamat',
        'jumlah',
        'kode_kas',
        'ket',
        'operator',
        'pr',
    ];

    public function pelangganRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan', 'kode');
    }

    public function itemPiutang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemPiutang::class, 'kode_piutang', 'kode');
    }
}
