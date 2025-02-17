<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
  protected $middlewareGroups = [
    'api' => [
      \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
      'throttle:api',
      \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'check-user-id' => \App\Http\Middleware\CheckUserId::class,
    'public-only-valid' => \App\Http\Middleware\PublicOnlyValidMiddleware::class,
  ];
}