<?php

namespace App\Models;



class Hutang extends TokoModel
{
    protected $table = 'hutang';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'supplier',
        'alamat',
        'jumlah',
        'kode_kas',
        'ket',
        'operator',
        'pr',
    ];

    public function supplierRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'kode');
    }

    public function itemHutang(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemHutang::class, 'kode_hutang', 'kode');
    }
}
