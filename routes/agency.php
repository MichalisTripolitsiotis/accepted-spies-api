<?php

declare(strict_types=1);

use App\UI\Http\Controllers\Api\V1\Agency\AgencyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('agency')->group(function () {
    Route::post('store', [AgencyController::class, 'store']);
    Route::get('all', [AgencyController::class, 'all']);
    Route::get('show/{id}', [AgencyController::class, 'show']);
});
