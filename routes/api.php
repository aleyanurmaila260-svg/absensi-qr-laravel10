<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/attendances/scan', [AttendanceController::class, 'scan']);
    Route::get('/attendances/history', [AttendanceController::class, 'history']);
    Route::get('/attendances/today', [AttendanceController::class, 'todayStatus']);
});
