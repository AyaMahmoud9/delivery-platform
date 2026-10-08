<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\DeliveryController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify', [AuthController::class, 'verifyMobile']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->get('/profile', [ProfileController::class, 'profile']);
Route::middleware('auth:api')->get(
    '/deliveries/nearest',
    [DeliveryController::class, 'nearest']
);