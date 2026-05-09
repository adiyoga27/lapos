<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\Hash;

class Karyawan extends TokoModel implements AuthenticatableContract
{
    use Authenticatable;

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

    protected $hidden = ['password'];

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
        return '';
    }

    public function getNameAttribute()
    {
        return $this->nama;
    }

    public function getEmailAttribute()
    {
        return null;
    }

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

    public function isAdmin(): bool
    {
        return in_array($this->level, ['ADMIN', 'admin']);
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (empty($this->level)) {
            return false;
        }

        static $cache = [];
        $key = $this->level;
        if (!isset($cache[$key])) {
            $level = Level::find($this->level);
            $cache[$key] = $level ? $level->getPermissionList() : [];
        }
        return in_array($permission, $cache[$key]);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (empty($this->level)) {
            return false;
        }

        foreach ($permissions as $perm) {
            if ($this->hasPermission($perm)) {
                return true;
            }
        }
        return false;
    }

    public function checkPassword(string $plainPassword): bool
    {
        if ($this->password === null) {
            return false;
        }

        if ($this->isBcrypt($this->password) && Hash::check($plainPassword, $this->password)) {
            return true;
        }

        if ($this->password === md5($plainPassword)) {
            return true;
        }

        if ($this->password === $plainPassword) {
            return true;
        }

        return false;
    }

    private function isBcrypt(string $hash): bool
    {
        return str_starts_with($hash, '$2y$') || str_starts_with($hash, '$2a$') || str_starts_with($hash, '$2b$');
    }
}
