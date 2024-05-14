<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Infrastructure\Http\Controllers\AuthController;
use App\Infrastructure\Http\Controllers\PaymentController;
use OpenApi\Annotations as OA;

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
    Route::apiResource('payments', PaymentController::class)->except(['update', 'destroy']);
});
