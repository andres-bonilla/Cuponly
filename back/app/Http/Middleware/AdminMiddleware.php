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
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado y si es admin
        if (auth()->check() && !auth()->user()->is_admin) {
            return response()->json([
                'error' => true,
                'data' => 'You are not authorized to access this resource.',
            ], 403); // 403 Forbidden
        }

        return $next($request);
    }
}
