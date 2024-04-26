<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\TokenVerificationController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,1');

Route::middleware(['auth:sanctum', 'auth:api'])->group(function () {
    Route::controller(TokenVerificationController::class)->prefix('token')->group(function () {
        Route::post('resend', 'resend')->middleware('throttle:10,2');
        Route::post('verify', 'verify')->middleware('throttle:10,2');
    });
    Route::post('logout', [AuthController::class, 'logout'])->middleware('throttle:10,1');
});
