<?php

use App\Http\Controllers\CouponsController;

Route::prefix('coupons')->group(function(){
  Route::post('/', [CouponsController::class, 'create']);
  Route::put('{id}', [CouponsController::class, 'update']);
  Route::delete('{id}', [CouponsController::class, 'delete']);
  Route::get('/', [CouponsController::class, 'getAll']);
  Route::get('{id}', [CouponsController::class, 'find']);
  Route::get('{id}/users', [CouponsController::class, 'getUsers']);
});