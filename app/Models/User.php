<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password', 'level'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function levelRef()
    {
        return $this->belongsTo(Level::class, 'level', 'kode');
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
}