<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            ['nome' => 'TESTE'],
            ['nome' => 'MULTIFILMES WINDOW FILM'],
            ['nome' => 'NICK PPF'],
            ['nome' => 'ORACAL'],
            ['nome' => 'OUTRAS'],
        ];

        foreach ($marcas as &$marca) {
            $marca['slug'] = Str::slug($marca['nome'], '-');
        }        

        DB::table('marcas')->insert($marcas);
    }
}
