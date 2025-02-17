<?php

use App\Http\Controllers\CouponsController;

Route::prefix('coupons')->group(function(){
  Route::post('/', [CouponsController::class, 'create'])
    ->middleware('auth:sanctum', 'admin');

  Route::post('{couponId}/to/{id}', [CouponsController::class, 'assign'])
    ->middleware('auth:sanctum', 'check-user-id');

  Route::post('generate', [CouponsController::class, 'generate']);

  Route::put('{id}', [CouponsController::class, 'update'])
    ->middleware('auth:sanctum', 'admin');

  Route::delete('{id}', [CouponsController::class, 'delete'])
    ->middleware('auth:sanctum', 'admin');

  Route::get('/', [CouponsController::class, 'getAll'])
    ->middleware('auth:sanctum', 'admin');

  Route::get('status/{status}', [CouponsController::class, 'filter'])
    ->middleware('public-only-valid'); 

  Route::get('{id}', [CouponsController::class, 'find']);

  Route::get('{id}/users', [CouponsController::class, 'getUsers'])
    ->middleware('auth:sanctum', 'admin');

  
});