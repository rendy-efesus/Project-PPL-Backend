<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AircraftController;
use App\Http\Controllers\Api\AirportController;
use App\Http\Controllers\Api\AircraftAvailableController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DraftQuotationController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (SANCTUM)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('aircraft')->group(function () {
        Route::get('/', [AircraftController::class, 'index']);
    });

    Route::prefix('airport')->group(function () {
        Route::get('/', [AirportController::class, 'index']);
    });

    Route::prefix('aircraft-available')->group(function () {
        Route::get('/', [AircraftAvailableController::class, 'index']);
    });

    // CUSTOMER CRUD
    Route::apiResource('customer', CustomerController::class);

    // DRAFT QUOTATION
    Route::apiResource('draft-quotation', DraftQuotationController::class);
});
