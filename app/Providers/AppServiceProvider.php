<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::if('perm', function (string $permission) {
            $user = auth()->user();
            if (!$user) {
                return false;
            }
            return $user->hasPermission($permission);
        });

        Blade::if('permAny', function (string ...$permissions) {
            $user = auth()->user();
            if (!$user) {
                return false;
            }
            return $user->hasAnyPermission($permissions);
        });
    }
}