<?php

namespace App\Models;



class SalesSupplier extends TokoModel
{
    protected $table = 'sales_supplier';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'telp',
        'kode_supplier',
    ];

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode');
    }
}
