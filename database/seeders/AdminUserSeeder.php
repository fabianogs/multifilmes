<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Feelingweb',
            'email' => 'contato@feelingweb.com.br',
            'password' => Hash::make('a1s2d3f4'),
            'email_verified_at' => now(),
        ]);
    }
} 