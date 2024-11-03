<?php

declare(strict_types=1);

use App\UI\Http\Controllers\Api\V1\Spy\SpyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('spy')->group(function () {
    Route::post('store', [SpyController::class, 'store']);
    Route::get('random', [SpyController::class, 'random'])->middleware('throttle:10,1');
    Route::get('all', [SpyController::class, 'all']);
});
