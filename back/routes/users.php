<?php

use App\Http\Controllers\UsersController;

Route::prefix('users')->group(function(){
  Route::post('/', [UsersController::class, 'create']);
  Route::put('{id}', [UsersController::class, 'update']);
  Route::delete('{id}', [UsersController::class, 'delete']);
  Route::get('/', [UsersController::class, 'getAll']);
  Route::get('{id}', [UsersController::class, 'find']);
  Route::get('{id}/coupons', [UsersController::class, 'coupons']);
});