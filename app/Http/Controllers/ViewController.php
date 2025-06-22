<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Solucao;
use App\Models\Unidade;
use App\Models\Post;
use App\Models\Config;
use App\Models\Banner;

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
        $banners = Banner::where('ativo', 1)->first();

        return view('site.home', compact('solucoes',
        'unidades',
                    'posts',
                    'config',
                    'qtd_posts',
                    'banners'
                ));
    }

    public function categorias_solucao($slug_solucao, $slug_categoria){

        $banners = Banner::where('ativo', 1)->first();

        $solucao = Solucao::where('slug', $slug_solucao)->with('categorias')->first();
        $categoria = Categoria::where('slug', $slug_categoria)->first();
        
        // Recuperar produtos que pertencem tanto à categoria quanto à solução
        $produtos = Produto::where('categoria_id', $categoria->id)
            ->whereHas('solucoes', function($query) use ($solucao) {
                $query->where('solucao_id', $solucao->id);
            })
            ->with(['marca', 'categoria'])
            ->get();
            
        return view('site.solucoes', compact('solucao', 'banners', 'categoria', 'produtos'));
    }

    public function blog(){

        $posts = Post::all();
        return view('site.blog', compact('posts'));
    }

    public function post($slug){
        $post = Post::where('slug', $slug)->with('imagensGaleria')->first();
        return view('site.post', compact('post'));
    }

    public function produto($slug){
        $produto = Produto::where('slug', $slug)->first();
        return view('site.produto', compact('produto'));
    }
}
