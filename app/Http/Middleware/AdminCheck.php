<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminCheck
{
    /**
     * Maneja la petición entrante.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin_access') || session('admin_access') !== true) {
            abort(404);
        }

        return $next($request);
    }
}