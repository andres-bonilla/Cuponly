<?php

use App\Http\Controllers\UsersController;

Route::prefix('users')->group(function(){
  Route::post('register', [UsersController::class, 'register']);

  Route::post('login', [UsersController::class, 'login'])->name('login');

  Route::post('logout', [UsersController::class, 'logout'])
    ->middleware('auth:sanctum');

  Route::put('{id}', [UsersController::class, 'update'])
    ->middleware('auth:sanctum', 'check-user-id');

  Route::delete('{id}', [UsersController::class, 'delete'])
    ->middleware('auth:sanctum', 'check-user-id');

  Route::get('/', [UsersController::class, 'getAll'])
    ->middleware('auth:sanctum', 'admin');

  Route::get('{id}', [UsersController::class, 'find'])
    ->middleware('auth:sanctum', 'check-user-id');

  Route::get('{id}/coupons', [UsersController::class, 'getCoupons'])
    ->middleware('auth:sanctum', 'check-user-id');
});