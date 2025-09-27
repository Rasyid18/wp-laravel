<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Wordpress\UserController;
use App\Http\Controllers\API\WordpressConnectionController;
use App\Http\Middleware\RefreshTokenExpiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', RefreshTokenExpiration::class])->group(function () {
    Route::controller(WordpressConnectionController::class)->prefix('connection')->group(function () {
        Route::get('/', 'show');
        Route::put('/', 'update');
        Route::post('test', 'test');
    });
    Route::prefix('wordpress')->group(function () {
        Route::apiResource('user', UserController::class);
    });
});
