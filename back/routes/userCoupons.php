<?php

use App\Http\Controllers\UserCouponsController;

Route::prefix('user-coupons')->group(function(){
  Route::middleware(['auth:sanctum'])->
  get('{id}/coupons', [UserCouponsController::class, 'getCoupons']);

  Route::middleware(['auth:sanctum'])
  ->get('users/{couponId}', [UserCouponsController::class, 'getUsers']);

  Route::middleware(['auth:sanctum'])
  ->post('{id}/{couponId}', [UserCouponsController::class, 'assign']);

  Route::middleware(['auth:sanctum'])
  ->put('{id}/has-invalid', [UserCouponsController::class, 'invalidate']);

  Route::middleware(['auth:sanctum'])
  ->put('{id}/{couponId}', [UserCouponsController::class, 'update']);
});