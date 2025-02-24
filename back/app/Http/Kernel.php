<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
  protected $middleware = [
    \Illuminate\Http\Middleware\HandleCors::class,
  ];

  protected $middlewareGroups = [
    'api' => [
      \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
      'throttle:api',
      \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
  ];
  
  protected $routeMiddleware = [
    'auth:sanctum' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'is-admin' => \App\Http\Middleware\IsAdmin::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'check-user-id' => \App\Http\Middleware\CheckUserId::class,
    'public-only-valid' => \App\Http\Middleware\PublicOnlyValidMiddleware::class,
    'disable_cors' => \App\Http\Middleware\DisableCORS::class,
];
}