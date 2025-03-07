<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado y tiene el rol de administrador
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request);
        }

        // Si no es administrador, devuelve un error 403 (Prohibido)
        return response()->json(['error' => 'Acceso solo para administradores'], 403);
    }
}
