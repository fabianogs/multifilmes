<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Run the database seeds.
     *
     * @return void
     */
/*******  bdbabdf4-0539-4e48-8728-fbb0ddd15964  *******/{
    public function run(): void
    {
        $categorias = [
            ['nome' => 'CONTROLE SOLAR'],
            ['nome' => 'ANTIVANDALISMO'],
            ['nome' => 'DECORATIVO'],
            ['nome' => 'ENVELOPAMENTO'],
            ['nome' => 'ARQUITETURA'],
            ['nome' => 'PPF - PROTEÇÃO PINTURA'],
            ['nome' => 'ESTÉTICA AUTOMOTIVA'],
        ];

        // Adiciona o slug para cada categoria
        foreach ($categorias as &$categoria) {
            $categoria['slug'] = Str::slug($categoria['nome'], '-');
        }

        DB::table('categorias')->insert($categorias);
    }
}
