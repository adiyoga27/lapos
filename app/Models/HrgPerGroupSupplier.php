<?php

namespace App\Models;



class HrgPerGroupSupplier extends TokoModel
{
    protected $table = 'hrgpergroup_supplier';
    public $timestamps = false;

    protected $fillable = [
        'kdgrouphrg',
        'harga',
        'harga2',
        'harga3',
        'kodebarang',
    ];

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(GrouphrgSupplier::class, 'kdgrouphrg', 'kode');
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kodebarang', 'kode');
    }
}
