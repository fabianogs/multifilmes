<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUnidadeAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Se for admin, permite acesso a tudo
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Se for franqueado, verifica se está tentando acessar rotas permitidas
        if ($user->role === 'franqueado') {
            $routeName = $request->route()->getName();
            
            // Lista de rotas permitidas para franqueados
            $allowedRoutes = [
                'config',
                'config.update',
                'seo.index',
                'seo.create',
                'seo.store',
                'seo.edit',
                'seo.update',
                'seo.destroy',
                'seo.updateExibir'
            ];

            // Se não for uma rota permitida, redireciona para o dashboard
            if (!in_array($routeName, $allowedRoutes)) {
                return redirect()->route('dashboard')
                    ->with('error', 'Você não tem permissão para acessar esta área.');
            }
        }

        return $next($request);
    }
} 