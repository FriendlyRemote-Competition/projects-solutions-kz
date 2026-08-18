<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/admin/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::get('/lines', [\App\Http\Controllers\Api\LineController::class, 'index']);
Route::get('/lines/{line}', [\App\Http\Controllers\Api\LineController::class, 'show']);
Route::get('/lines/{line}/timetable', [\App\Http\Controllers\Api\LineController::class, 'timetable']);

Route::post('/bookings', [\App\Http\Controllers\Api\BookingController::class, 'store']);
Route::post('/bookings/lookup', [\App\Http\Controllers\Api\BookingController::class, 'lookup']);
Route::patch('/bookings/{code}', [\App\Http\Controllers\Api\BookingController::class, 'update']);
Route::post('/bookings/{code}/cancel', [\App\Http\Controllers\Api\BookingController::class, 'cancel']);

Route::middleware('check.token')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/bookings', [\App\Http\Controllers\Api\AdminBookingController::class, 'index']);

        Route::middleware('check.admin')->group(function () {
            Route::post('/lines', [\App\Http\Controllers\Api\AdminLineController::class, 'store']);
            Route::put('/lines/{line}', [\App\Http\Controllers\Api\AdminLineController::class, 'update']);
            Route::post('/lines/{line}/service-windows', [\App\Http\Controllers\Api\AdminLineController::class, 'storeWindow']);
            Route::delete('/lines/{line}/service-windows/{startTime}', [\App\Http\Controllers\Api\AdminLineController::class, 'destroyWindow']);
        });

        Route::post('/departures/{code}/cancel', [\App\Http\Controllers\Api\AdminDepartureController::class, 'cancel']);
    });
});
