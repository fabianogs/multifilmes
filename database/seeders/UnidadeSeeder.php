<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadeSeeder extends Seeder
{
    public function run()
    {
        $unidades = [
            ['nome' => 'MASTER', 'cidade' => 'MASTER', 'uf' => 'MM'],
            ['nome' => 'MULTIFILMES BRASILIA', 'cidade' => 'Brasília', 'uf' => 'DF'],
            ['nome' => 'JW Natal Comércio e Serviços de Películas de Vidro LTDA', 'cidade' => 'Natal', 'uf' => 'RN'],
            ['nome' => 'BRITO DE BARROS PELÍCULAS LTDA', 'cidade' => 'Salvador', 'uf' => 'BA'],
            ['nome' => 'GROLA & FILHOS LTDA', 'cidade' => 'São José dos Pinhais', 'uf' => 'PR'],
            ['nome' => 'BELO HORIZONTE COMERCIO DE PELICULAS PARA VIDROS EIRELI', 'cidade' => 'Belo Horizonte', 'uf' => 'MG'],
            ['nome' => 'VITORIA ESTETICA AUTOMOTIVA E ARQUITETONICA LTDA', 'cidade' => 'Vitória', 'uf' => 'ES'],
            ['nome' => 'FASHION MODAS', 'cidade' => 'Macapá', 'uf' => 'AP'],
            ['nome' => 'Figueiredo e Leal Peliculas LTDA', 'cidade' => 'Imperatriz', 'uf' => 'MA'],
            ['nome' => 'ARAGUAINA COM. DE PELICULAS PARA VIDROS LTDA', 'cidade' => 'Araguaína', 'uf' => 'TO'],
            ['nome' => 'SOROCABA COMERCIO DE PELICULAS PARA VIDROS LTDA', 'cidade' => 'Sorocaba', 'uf' => 'SP'],
            ['nome' => 'Multifilmes Window Film LTDA', 'cidade' => 'Ribeirão Preto', 'uf' => 'SP'],
            ['nome' => 'THE MASTER COMERCIAL LTDA', 'cidade' => 'Palmas', 'uf' => 'TO'],
            ['nome' => 'SAO CAETANO DO SUL COMERCIO DE PELICULAS PARA VIDROS LTDA', 'cidade' => 'São Caetano do Sul', 'uf' => 'SP'],
            ['nome' => '0000000', 'cidade' => 'São Paulo', 'uf' => 'SP'],
            ['nome' => 'Multifilmes Florianópolis ', 'cidade' => 'Florianópolis', 'uf' => 'SC'],
            ['nome' => 'Multifilmes Feira de Santana -  BA', 'cidade' => 'Feira de Santana', 'uf' => 'BA'],
            ['nome' => 'Multifilmes Porto Alegre - RS', 'cidade' => 'Porto Alegre', 'uf' => 'RS'],
            ['nome' => 'Multifilmes BH', 'cidade' => 'Belo Horizonte', 'uf' => 'MG'],
            ['nome' => 'Multifilmes Vila Velha', 'cidade' => 'Vila Velha', 'uf' => 'ES'],
        ];

        foreach ($unidades as $unidade) {
            DB::table('unidades')->updateOrInsert(
                [
                    'nome' => $unidade['nome'],
                    'cidade' => $unidade['cidade'],
                    'uf' => $unidade['uf'],
                ],
                $unidade
            );
        }
    }
}
