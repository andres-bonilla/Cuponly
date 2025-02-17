<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicOnlyValidMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $status): Response
    {
        // Si el estado es "valid", permitimos el acceso público
        if ($status === 'valid') {
            return $next($request);
        }

        // Si el estado no es "valid", verificamos si el usuario es admin
        if (auth()->user() && auth()->user()->is_admin) {
            return $next($request);
        }

        // Si el usuario no es admin, denegamos el acceso
        return response()->json([
            'error' => true,
            'message' => 'You are not authorized to access this resource.'
        ], 403);
    }
}
