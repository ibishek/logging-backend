<?php

use App\Http\Controllers\V1\InitialUserController;
use App\Http\Controllers\V1\Organization\OrganizationController;
use App\Http\Controllers\V1\Register\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class);

Route::middleware(['auth:sanctum', 'auth:api'])->group(function () {
    Route::get('user', InitialUserController::class);

    Route::middleware('verified')->group(function () {
        Route::prefix('organizations')->group(function () {
            Route::get('{slug}', [OrganizationController::class, 'show']);
            Route::post('/', [OrganizationController::class, 'store'])->middleware('throttle:10,2');
            Route::post('{slug}/logo', [OrganizationController::class, 'logo'])->middleware('throttle:10,1');
            Route::post('{slug}/background-image', [OrganizationController::class, 'backgroundImage'])->middleware('throttle:10,1');
            Route::put('{slug}', [OrganizationController::class, 'update']);
        });
    });
});
