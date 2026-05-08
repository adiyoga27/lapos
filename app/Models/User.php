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

    public function hasPermission(string $permission): bool
    {
        if (!$this->level) {
            return false;
        }
        $level = Level::find($this->level);
        if (!$level) {
            return false;
        }
        return $level->hasPermission($permission);
    }

    public function getPermissions(): array
    {
        if (!$this->level) {
            return [];
        }
        $level = Level::find($this->level);
        if (!$level) {
            return [];
        }
        return $level->getPermissionList();
    }

    public function isAdmin(): bool
    {
        $adminLevels = ['ADMIN', 'admin', 'Admin'];
        return in_array($this->level, $adminLevels);
    }
}