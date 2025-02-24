<?php

use App\Http\Controllers\UsersController;

Route::prefix('users')->group(function(){
  Route::post('register', [UsersController::class, 'register']);

  Route::post('login', [UsersController::class, 'login'])->name('login');

  Route::middleware(['auth:sanctum'])
  ->post('logout', [UsersController::class, 'logout']);

  Route::middleware(['auth:sanctum'])
  ->put('{id}', [UsersController::class, 'update']);

  Route::middleware(['auth:sanctum'])
  ->delete('{id}', [UsersController::class, 'delete']);

  Route::middleware(['auth:sanctum'])
  ->get('/', [UsersController::class, 'getAll']);

  Route::middleware(['auth:sanctum'])
  ->get('{id}', [UsersController::class, 'find']);
});