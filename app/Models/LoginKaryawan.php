<?php

namespace App\Models;



class LoginKaryawan extends TokoModel
{
    protected $table = 'loginkaryawan';
    protected $primaryKey = 'pr';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'tanggal_login',
        'tanggal_logout',
        'jam_login',
        'jam_logout',
        'kodekaryawan',
        'shif',
        'pr',
        'hos',
        'tampil',
        'kasawal',
        'operatorbefore',
        'status',
        'kasakhir',
        'prbefore',
    ];

    public function karyawan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'kodekaryawan', 'kode');
    }
}
