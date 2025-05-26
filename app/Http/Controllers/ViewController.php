<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Solucao;
use App\Models\Unidade;
use App\Models\Post;
use App\Models\Config;


class ViewController extends Controller
{
    public function index()
    {

        $marcas = Marca::all()->count();
        $produtos = Produto::all()->count();
        $categorias = Categoria::all()->count();
        $solucoes = Solucao::all()->count();
        $unidades = Unidade::all()->count();
        $solucoes = Solucao::all()->count();
        $posts = Post::all()->count();
        return view('dashboard', compact('marcas', 
        'produtos', 
        'categorias', 
        'solucoes',
        'unidades',
        'solucoes',
        'posts'
    ));
    }

    public function home(){
        $solucoes = Solucao::with('categorias')->get();
        $unidades = Unidade::orderBy('cidade', 'asc')->get();
        $posts = Post::all();
        $config = Config::first();
        $qtd_posts = Post::all()->count();

        return view('site.home', compact('solucoes',
        'unidades',
                    'posts',
                    'config',
                    'qtd_posts'
                ));
    }

    public function solucoes($slug){

        $solucao = Solucao::where('slug', $slug)->with('categorias')->first();
        return view('site.solucoes', compact('solucao'));
    }

    public function blog(){

        $posts = Post::all();
        return view('site.blog', compact('posts'));
    }

    public function post($slug){
        $post = Post::where('slug', $slug)->with('imagensGaleria')->first();
        return view('site.post', compact('post'));
    }
}
