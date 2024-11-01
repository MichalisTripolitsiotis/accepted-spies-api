<?php

declare(strict_types=1);

use App\UI\Http\Controllers\Api\V1\Auth\AuthController;
use App\UI\Http\Controllers\Api\V1\Spy\SpyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('spy')->group(function () {
        Route::post('store', [SpyController::class, 'store']);
    });
});
