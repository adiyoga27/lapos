<?php

namespace App\Models;



class TukarPoint extends TokoModel
{
    protected $table = 'tukar_point';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'jam',
        'id_member',
        'kode_barang',
        'nama_barang',
        'satuan',
        'qty',
        'harga',
        'jumlah',
        'point_sebelum',
        'point_kredit',
        'operator',
        'hpp',
        'jenis_tukar_point',
        'kode_kas',
    ];

    public function member(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_kartu');
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode');
    }
}
