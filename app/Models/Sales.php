<?php

namespace App\Models;



class Sales extends TokoModel
{
    protected $table = 'sales';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'telp',
    ];

    public function canvas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Canvas::class, 'kd_sales', 'kode');
    }

    public function pelanggan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pelanggan::class, 'sales', 'kode');
    }

    public function salesSupplier(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SalesSupplier::class, 'kode_supplier', 'kode');
    }
}
