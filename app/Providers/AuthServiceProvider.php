<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function register(): void
    {
        $this->app->singleton('auth', function ($app) {
            return new \Illuminate\Auth\AuthManager($app);
        });
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para verificar se é admin
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        // Gate para verificar se é franqueado
        Gate::define('franqueado', function ($user) {
            return $user->isFranqueado();
        });

        // Gate para verificar acesso à unidade
        Gate::define('acessar-unidade', function ($user, $unidadeId) {
            if ($user->isAdmin()) {
                return true;
            }
            return $user->isFranqueado() && $user->unidade_id == $unidadeId;
        });

        // Gate para verificar acesso aos recursos
        Gate::define('acessar-recurso', function ($user, $recurso) {
            if ($user->isAdmin()) {
                return true;
            }
            return $user->isFranqueado() && $recurso->unidade_id == $user->unidade_id;
        });
    }
} 