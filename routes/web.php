<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\SeoController;

Route::get('/', [App\Http\Controllers\ViewController::class, 'home'])->name('site.home');
Route::get('/home', [App\Http\Controllers\ViewController::class, 'home'])->name('site.home');
Route::get('/quem-somos', function () {
    return view('site.quem-somos');
})->name('site.quem-somos');
Route::get('/solucoes/{slug}', [App\Http\Controllers\ViewController::class, 'solucoes'])->name('site.solucoes');
Route::get('/blog', [App\Http\Controllers\ViewController::class, 'blog'])->name('site.blog');
Route::get('/unidades', function () {
    return view('site.unidades');
})->name('site.unidades');
Route::get('/post/{slug}', [App\Http\Controllers\ViewController::class, 'post'])->name('site.post');

Route::middleware('auth')->prefix('area_restrita')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [App\Http\Controllers\ViewController::class, 'index'])->name('dashboard');

    // Rotas de Configuração e SEO (acessíveis para todos os usuários autenticados)
    Route::get('/config', [ConfigController::class, 'edit'])->name('config');
    Route::put('/config/update/{id}', [ConfigController::class, 'update'])->name('config.update');    

    Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
    Route::get('/seo/create', [SeoController::class, 'create'])->name('seo.create');
    Route::post('/seo/store', [SeoController::class, 'store'])->name('seo.store');
    Route::get('/seo/edit/{id}', [SeoController::class, 'edit'])->name('seo.edit');
    Route::put('/seo/update/{id}', [SeoController::class, 'update'])->name('seo.update');
    Route::delete('/seo/delete/{id}', [SeoController::class, 'destroy'])->name('seo.destroy');
    Route::post('/admin/seos/update-exibir', [SeoController::class, 'updateExibir'])->name('seo.updateExibir');

    // Rotas que precisam de autenticação e verificação de admin
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        // Usuários
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
        Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

        // Unidades
        Route::get('/unidades', [UnidadeController::class, 'index'])->name('unidades.index');
        Route::get('/unidades/create', [UnidadeController::class, 'create'])->name('unidades.create');
        Route::post('/unidades', [UnidadeController::class, 'store'])->name('unidades.store');
        Route::get('/unidades/{id}', [UnidadeController::class, 'show'])->name('unidades.show');
        Route::get('/unidades/{id}/edit', [UnidadeController::class, 'edit'])->name('unidades.edit');
        Route::put('/unidades/{id}', [UnidadeController::class, 'update'])->name('unidades.update');
        Route::delete('/unidades/{id}', [UnidadeController::class, 'destroy'])->name('unidades.destroy');

        // Banners
        Route::get('/banners', [App\Http\Controllers\BannerController::class, 'index'])->name('banners.index');
        Route::get('/banners/create', [App\Http\Controllers\BannerController::class, 'create'])->name('banners.create');
        Route::post('/banners', [App\Http\Controllers\BannerController::class, 'store'])->name('banners.store');
        Route::get('/banners/{id}', [App\Http\Controllers\BannerController::class, 'show'])->name('banners.show');    
        Route::get('/banners/{id}/edit', [App\Http\Controllers\BannerController::class, 'edit'])->name('banners.edit');
        Route::put('/banners/{id}', [App\Http\Controllers\BannerController::class, 'update'])->name('banners.update');    
        Route::delete('/banners/{id}', [App\Http\Controllers\BannerController::class, 'destroy'])->name('banners.destroy'); 
        Route::post('/banners/{id}/delete-image', [App\Http\Controllers\BannerController::class, 'deleteImage'])->name('banners.delete-image');
        Route::post('/banners/set_ativo/{id}', [App\Http\Controllers\BannerController::class, 'set_ativo'])->name('banners.set_ativo');

        // Soluções
        Route::get('/solucoes', [App\Http\Controllers\SolucaoController::class, 'index'])->name('solucoes.index');
        Route::get('/solucoes/create', [App\Http\Controllers\SolucaoController::class, 'create'])->name('solucoes.create');
        Route::post('/solucoes', [App\Http\Controllers\SolucaoController::class, 'store'])->name('solucoes.store');
        Route::get('/solucoes/{id}', [App\Http\Controllers\SolucaoController::class, 'show'])->name('solucoes.show');
        Route::get('/solucoes/{id}/edit', [App\Http\Controllers\SolucaoController::class, 'edit'])->name('solucoes.edit');
        Route::put('/solucoes/{id}', [App\Http\Controllers\SolucaoController::class, 'update'])->name('solucoes.update');
        Route::delete('/solucoes/{id}', [App\Http\Controllers\SolucaoController::class, 'destroy'])->name('solucoes.destroy');

        // Categorias
        Route::get('/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categorias.index');
        Route::get('/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('categorias.create');
        Route::post('/categorias', [App\Http\Controllers\CategoriaController::class, 'store'])->name('categorias.store');
        Route::get('/categorias/{categoria}', [App\Http\Controllers\CategoriaController::class, 'show'])->name('categorias.show');
        Route::get('/categorias/{categoria}/edit', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('categorias.edit');
        Route::put('/categorias/{categoria}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('categorias.update');
        Route::delete('/categorias/{categoria}', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('categorias.destroy');

        // Marcas
        Route::get('/marcas', [App\Http\Controllers\MarcaController::class, 'index'])->name('marcas.index');
        Route::get('/marcas/create', [App\Http\Controllers\MarcaController::class, 'create'])->name('marcas.create');
        Route::post('/marcas', [App\Http\Controllers\MarcaController::class, 'store'])->name('marcas.store');
        Route::get('/marcas/{id}', [App\Http\Controllers\MarcaController::class, 'show'])->name('marcas.show');
        Route::get('/marcas/{id}/edit', [App\Http\Controllers\MarcaController::class, 'edit'])->name('marcas.edit');
        Route::put('/marcas/{id}', [App\Http\Controllers\MarcaController::class, 'update'])->name('marcas.update');
        Route::delete('/marcas/{id}', [App\Http\Controllers\MarcaController::class, 'destroy'])->name('marcas.destroy');

        // Produtos
        Route::get('/produtos', [App\Http\Controllers\ProdutoController::class, 'index'])->name('produtos.index');
        Route::get('/produtos/create', [App\Http\Controllers\ProdutoController::class, 'create'])->name('produtos.create');
        Route::post('/produtos', [App\Http\Controllers\ProdutoController::class, 'store'])->name('produtos.store');
        Route::get('/produtos/{id}', [App\Http\Controllers\ProdutoController::class, 'show'])->name('produtos.show');
        Route::get('/produtos/{id}/edit', [App\Http\Controllers\ProdutoController::class, 'edit'])->name('produtos.edit');
        Route::put('/produtos/{id}', [App\Http\Controllers\ProdutoController::class, 'update'])->name('produtos.update');
        Route::delete('/produtos/{id}', [App\Http\Controllers\ProdutoController::class, 'destroy'])->name('produtos.destroy');
        Route::post('/produtos/set_ativo/{id}', [App\Http\Controllers\ProdutoController::class, 'set_ativo'])->name('produtos.set_ativo');

        // Posts
        Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [App\Http\Controllers\PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{id}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');
        Route::get('/posts/{id}/edit', [App\Http\Controllers\PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy');
        Route::post('/posts/set_ativo/{id}', [App\Http\Controllers\PostController::class, 'set_ativo'])->name('posts.set_ativo');
        Route::post('posts/upload', [PostController::class, 'upload'])->name('posts.upload');
    });
});

Route::get('/test-admin-gate', function () {
    return 'Teste do Gate Admin';
})->middleware(['web', 'auth', 'check.admin.gate']);

require __DIR__.'/auth.php';
