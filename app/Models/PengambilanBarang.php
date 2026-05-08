<?php

namespace App\Models;



class PengambilanBarang extends TokoModel
{
    protected $table = 'pengambilanbarang';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'kode_kas',
        'kode_barang',
        'nama_barang',
        'satuan',
        'qty',
        'harga',
        'jumlah',
        'operator',
        'lokasistok',
        'ket',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
