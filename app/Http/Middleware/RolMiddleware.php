<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    /**
     * $rol viene del middleware('rol:chofer') o ('rol:pasajero')
     */
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        if (!auth()->check()) {
            // No está logueado
            return redirect()->route('login');
        }

        if (auth()->user()->tipo !== $rol) {
            // Está logueado pero no es del rol correcto
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
