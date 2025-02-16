<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working.'], 200);
});

require base_path('routes/coupons.php');

require base_path('routes/users.php');