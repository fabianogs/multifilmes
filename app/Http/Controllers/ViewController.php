<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Solucao;
use App\Models\Unidade;
use App\Models\Post;
use App\Models\Config;
use App\Models\Banner;
use App\Models\User;

class ViewController extends Controller
{
    public function index()
    {
        // Contadores básicos
        $marcas = Marca::all()->count();
        $categorias = Categoria::all()->count();
        $solucoes = Solucao::all()->count();
        $unidades = Unidade::all()->count();
        $posts = Post::all()->count();
        $banners = Banner::all()->count();
        $usuarios = User::all()->count();
        $configs = Config::all()->count();

        // Dados recentes para as tabelas
        $postsRecentes = Post::orderBy('created_at', 'desc')->limit(5)->get();
        $bannersAtivos = Banner::where('ativo', 1)->orderBy('created_at', 'desc')->limit(5)->get();

        return view('dashboard', compact(
            'marcas', 
            'categorias', 
            'solucoes',
            'unidades',
            'posts',
            'banners',
            'usuarios',
            'configs',
            'postsRecentes',
            'bannersAtivos'
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

    public function categorias_solucao($slug_solucao){
        $banners = Banner::where('ativo', 1)->first();
        $solucao = Solucao::where('slug', $slug_solucao)->with('categorias')->first();
        $config = Config::first();
    
        return view('site.solucoes', compact('solucao', 'banners', 'config'));
    }

    public function blog(){
        $banners = Banner::where('ativo', 1)->first();
        $posts = Post::all();
        $config = Config::first();
        return view('site.blog', compact('posts', 'config', 'banners'));
    }

    public function post($slug){
        $banners = Banner::where('ativo', 1)->first();
        $post = Post::where('slug', $slug)->with('imagensGaleria')->first();
        $config = Config::first();
        return view('site.post', compact('post', 'config', 'banners'));
    }

    public function quemSomos(){
        $config = Config::first();
        return view('site.quem-somos', compact('config'));
    }

    public function unidades(){
        $config = Config::first();
        return view('site.unidades', compact('config'));
    }
}
