<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminGate
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        dd([
            'middleware_check' => [
                'user_id' => $user->id,
                'role' => $user->role,
                'isAdmin' => $user->isAdmin(),
                'canAdmin' => $user->can('admin')
            ]
        ]);

        return $next($request);
    }
} 