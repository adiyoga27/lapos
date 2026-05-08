<?php

namespace App\Models;



class HrgPerGroup extends TokoModel
{
    protected $table = 'hrgpergroup';
    public $timestamps = false;

    protected $fillable = [
        'kdgrouphrg',
        'hrg_toko_1',
        'hrg_toko_2',
        'hrg_toko_3',
        'hrg_partai_1',
        'hrg_partai_2',
        'hrg_partai_3',
        'kodebarang',
    ];

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(GrouphrgPelanggan::class, 'kdgrouphrg', 'kode');
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kodebarang', 'kode');
    }
}
