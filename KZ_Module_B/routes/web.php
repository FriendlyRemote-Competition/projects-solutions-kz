<?php

use Illuminate\Support\Facades\Route;

Route::prefix('KZ_Module_B')->group(function () {
    Route::get('/board', [\App\Http\Controllers\BoardController::class, 'index']);
    Route::get('/board/{station}', [\App\Http\Controllers\BoardController::class, 'show']);
});
