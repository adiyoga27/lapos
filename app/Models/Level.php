<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends TokoModel
{
    protected $table = 'level';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'f_perusahaan',
        'footer',
        'edit_f_perusahaan',
        'f_level',
        'insert_f_level',
        'edit_f_level',
        'hapus_f_level',
        'f_karyawan',
        'insert_f_karyawan',
        'edit_f_karyawan',
        'hapus_f_karyawan',
        'f_kategori',
        'insert_f_kategori',
        'edit_f_kategori',
        'hapus_f_kategori',
    ];

    public function karyawan(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'level', 'kode');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(LevelPermission::class, 'level_kode', 'kode');
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('permission', $permission)->exists();
    }

    public function getPermissionList(): array
    {
        return $this->permissions()->pluck('permission')->toArray();
    }
}