<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Infrastructure\Http\Controllers\AuthController;
use App\Infrastructure\Http\Controllers\PaymentController;

// Open Routes
// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login'])->name('login');

// // Protected Routes
// Route::group([
//     'middleware' => ['auth:sanctum']
// ], function() {
//     Route::get('profile', [AuthController::class, 'profile']);
//     Route::get('logout', [AuthController::class, 'logout']);
//     Route::apiResource('payment', PaymentController::class);
// });

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($routers) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    // Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    // Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});
