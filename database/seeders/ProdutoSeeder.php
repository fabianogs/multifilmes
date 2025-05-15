<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        $produtos = [
            ['nome' => 'ECONOMY GRAFITE 05%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'NANO CRYSTAL GRAFITE 20%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'NANO CRYSTAL GRAFITE 05%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'NANO CRYSTAL GRAFITE 40%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'NANO CRYSTAL GRAFITE 70%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'NANO CRYSTAL GRAFITE 80%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'ECONOMY GRAFITE 20%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'ECONOMY GRAFITE 35%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'ECONOMY GRAFITE 50%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'PREMIUM GRAFITE 05%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'PREMIUM GRAFITE 20%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'PREMIUM GRAFITE 35%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'PREMIUM GRAFITE 50%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'PREMIUM GRAFITE 70%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'SUPREME CARBON GRAFITE 05%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'SUPREME CARBON GRAFITE 20%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'SUPREME CARBON GRAFITE 35%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'SUPREME CARBON GRAFITE 50%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'SUPREME CARBON GRAFITE 70%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'PREMIUM AVIATOR 05%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'PREMIUM AVIATOR 20%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'PREMIUM AVIATOR 35%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'PREMIUM AVIATOR 50%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'TITANIUM - GRAFITE 05%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'TITANIUM - GRAFITE 20%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'TITANIUM - GRAFITE 35%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'TITANIUM - GRAFITE 50%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'TITANIUM - GRAFITE 70%', 'marca_id' => 2, 'categoria_id' => 2],
            ['nome' => 'BLACKOUT', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'BLUE SILVER 05%', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'BOLD BLOCK', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'BRONZE SILVER', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'BROWN OPAQUE', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'COBRE SILVER', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'GOLD SILVER', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'GREEN SILVER', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'MINI BLIND', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'MINI BLOCK', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'MINI PERFURADO', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'NATURAL BROWN', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'NATURAL GREEN', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'NATURAL ORANGE', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'NATURAL RED', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'NATURAL YELLOW', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'RED SILVER', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'SILVER 05%', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'SILVER 15%', 'marca_id' => 2, 'categoria_id' => 7],
            ['nome' => 'VENECTIAN', 'marca_id' => 2, 'categoria_id' => 4],
            ['nome' => 'VENECTIAN PLUS', 'marca_id' => 2, 'categoria_id' => 4],
            ['nome' => 'WHITE OPAQUE', 'marca_id' => 2, 'categoria_id' => 4],
            ['nome' => 'WHITE OPAQUE CRYSTAL', 'marca_id' => 2, 'categoria_id' => 4],
            ['nome' => 'WHITEOUT', 'marca_id' => 2, 'categoria_id' => 4],
        ];

        foreach ($produtos as &$produto) {
            $produto['slug'] = Str::slug($produto['nome'], '-');
        }        

        DB::table('produtos')->insert($produtos);              
    }
}
