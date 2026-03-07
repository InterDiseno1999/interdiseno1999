<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminCheck
{
    /**
     * Maneja la petición entrante.
     * Si no existe la sesión 'admin_access', lanza un error 404 (Página no encontrada).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin_access') || session('admin_access') !== true) {
            // Usamos 404 en lugar de 403 para que la ruta parezca inexistente
            abort(404);
        }

        return $next($request);
    }
}