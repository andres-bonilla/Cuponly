<?php

use App\Http\Controllers\CouponsController;

Route::prefix('coupons')->group(function(){
  Route::middleware(['auth:sanctum'])
  ->post('/create', [CouponsController::class, 'create']);

  Route::post('has-expired', [CouponsController::class, 'expire']);

  Route::middleware(['auth:sanctum'])
  ->put('{id}', [CouponsController::class, 'update']);

  Route::middleware(['auth:sanctum'])
  ->delete('{id}', [CouponsController::class, 'delete']);

  Route::middleware(['auth:sanctum'])
  ->get('/', [CouponsController::class, 'getAll']);

  Route::get('status/{status}', [CouponsController::class, 'filter']);

  Route::middleware(['auth:sanctum'])
  ->get('{id}', [CouponsController::class, 'find']);
});