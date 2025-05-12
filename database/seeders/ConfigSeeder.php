<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Config::create([
            'id' => 1,
        ]);
    }
} 