<?php

namespace App\Models;



class Member extends TokoModel
{
    protected $table = 'member';
    protected $primaryKey = 'id_kartu';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'alamat',
        'tgl_lahir',
        'agama',
        'pekerjaan',
        'jenis_id',
        'no_id',
        'no_telp',
        'id_kartu',
        'no_kartu',
        'area',
        'expired',
        'point',
        'saldo_piutang',
        'komisi',
        'max_piutang',
        'email',
        'tampil',
        'sisa',
        'referal',
        'pelanggan_kena_pajak',
        'nonpwp',
    ];

    public function tukarPoint(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TukarPoint::class, 'id_member', 'id_kartu');
    }
}
