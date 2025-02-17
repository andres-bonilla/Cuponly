<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $id): Response
    {
        if (auth()->user()->is_admin || auth()->user()->id == $id) {
            return $next($request);
        }

        // Si no es admin y el ID no coincide, retorna un error 403
        return response()->json([
            'error' => true,
            'message' => 'You are not authorized to access this resource.'
        ], 403);
    }
}
