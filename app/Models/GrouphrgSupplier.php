<?php

namespace App\Models;



class GrouphrgSupplier extends TokoModel
{
    protected $table = 'grouphrgsupplier';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
    ];

    public function hrgPerGroupSupplier(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(HrgPerGroupSupplier::class, 'kdgrouphrg', 'kode');
    }

    public function supplier(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Supplier::class, 'kdgrouphrg', 'kode');
    }
}
