<?php

namespace App\Models;



class Karyawan extends TokoModel
{
    protected $table = 'karyawan';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'telp',
        'tgl_lahir',
        'level',
        'password',
        'shif',
        'status',
    ];

    public function levelRef(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Level::class, 'level', 'kode');
    }

    public function loginKaryawan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LoginKaryawan::class, 'kodekaryawan', 'kode');
    }

    public function absensi(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Absensi::class, 'kode', 'kode');
    }
}
