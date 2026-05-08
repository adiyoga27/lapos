<?php

namespace App\Models;



class BarangDiskon extends TokoModel
{
    protected $table = 'barang_diskon';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'operator',
        'jum1',
        'jum2',
        'pilihan',
        'nilai',
        'periode_mulai',
        'periode_sampai',
        'kode_barang',
        'qty',
        'harga',
        'nama_barang',
        'ada_periode',
        'diskon',
        'global',
        'jenis_global',
        'isi',
        'satuan',
        'cek',
        'no',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
