<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Solucao;


class ViewController extends Controller
{
    public function index()
    {
        //contagem de marcas

        $marcas = Marca::all()->count();
        $produtos = Produto::all()->count();
        $categorias = Categoria::all()->count();
        $solucoes = Solucao::all()->count();
        return view('dashboard', compact('marcas', 
        'produtos', 
        'categorias', 
        'solucoes'));
    }
}
