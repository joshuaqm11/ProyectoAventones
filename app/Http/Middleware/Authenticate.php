<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Maneja una petición entrante.
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        // Si NO está logueado → lo mandamos al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Si está logueado, sigue la petición
        return $next($request);
    }
}
