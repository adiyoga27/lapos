<?php

namespace App\Models;



class PengirimanPo extends TokoModel
{
    protected $table = 'pengirimanpo';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'tanggal',
        'pelanggan',
        'jasakirim',
        'biayakirim',
        'namapengirim',
        'alamatpengirim',
        'namapenerima',
        'alamatpenerima',
    ];

    public function pelangganRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan', 'kode');
    }
}
