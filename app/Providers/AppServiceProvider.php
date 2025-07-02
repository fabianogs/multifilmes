<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Solucao;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App::setLocale('pt-br');
        
        // View Composer para o header
        View::composer('layouts.header', function ($view) {
            $headerSolucoes = Solucao::with('categorias')->get();
            $view->with('headerSolucoes', $headerSolucoes);
        });
    }
}
