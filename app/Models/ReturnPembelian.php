<?php

namespace App\Models;



class ReturnPembelian extends TokoModel
{
    protected $table = 'return_pembelian';
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
        'no_faktur',
        'tgl_beli',
        'supplier',
        'sn',
        'qty',
        'harga',
        'jumlah',
        'alasan',
        'kode_kas',
        'operator',
        'kembali',
        'lokasistok',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }

    public function supplierRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'kode');
    }

    public function pembelian(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'no_faktur', 'kode');
    }
}
