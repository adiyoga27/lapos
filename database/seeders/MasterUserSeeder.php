<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class MasterUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Master',
            'username' => 'master',
            'email' => 'master@retailpro.com',
            'password' => bcrypt(''),
            'email_verified_at' => now(),
        ]);
    }
}
