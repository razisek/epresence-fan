<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EpresenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // epresence
    Route::get('/epresence', [EpresenceController::class, 'index']);
    Route::post('/epresence', [EpresenceController::class, 'store']);
    Route::post('/epresence/{id}/approve', [EpresenceController::class, 'approve']);

    // auth
    Route::post('/logout', [AuthController::class, 'logout']);
});
