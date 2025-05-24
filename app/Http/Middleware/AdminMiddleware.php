<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!auth()->check() || !$user->can('admin')) {
            return redirect()->route('dashboard')->with('error', 'Você não tem permissão para acessar esta área.');
        }

        return $next($request);
    }
} 