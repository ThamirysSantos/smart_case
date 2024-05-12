<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Infrastructure\Http\Controllers\AuthController;

// Open Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected Routes
Route::group([
    'middleware' => ['auth:sanctum']
], function() {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('logout', [AuthController::class, 'logout']);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
