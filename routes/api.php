<?php

use App\Http\Controllers\Api\AircraftAvailableController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AircraftController;
use App\Http\Controllers\Api\AirportController;

Route::prefix('aircraft')->group(function () {
    Route::get('/', [AircraftController::class, 'index']);
});

Route::prefix('airport')->group(function () {
    Route::get('/', [AirportController::class, 'index']);
});

Route::get('/aircraft-available', [AircraftAvailableController::class, 'index']);
