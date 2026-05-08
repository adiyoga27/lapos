<?php

namespace App\Models;



class ReturnPenjualan extends TokoModel
{
    protected $table = 'return_penjualan';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'jenis_penjualan',
        'no_faktur',
        'tgl_jual',
        'kode_barang',
        'nama_barang',
        'satuan',
        'sn',
        'qty',
        'harga',
        'diskon',
        'jumlah',
        'alasan',
        'kode_kas',
        'operator',
        'hpp',
        'pr',
        'tipe',
        'kode_header',
        'lokasistok',
        'isi',
    ];

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'no_faktur', 'kode');
    }
}
