<?php

namespace App\Models;



class PenerimaanReturn extends TokoModel
{
    protected $table = 'penerimaan_return';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'kode_barang',
        'nama_barang',
        'satuan',
        'kode_return',
        'tanggal_return',
        'sn_lama',
        'qty_terima',
        'harga',
        'jumlah',
        'ket',
        'operator',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }

    public function returnPembelian(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ReturnPembelian::class, 'kode_return', 'kode');
    }
}
