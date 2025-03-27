<?php

use App\Http\Controllers\HallController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protect routes with JWT authentication
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/halls', [HallController::class, 'index']);
    Route::get('/halls/{id}', [HallController::class, 'show']);
    Route::post('/halls', [HallController::class, 'store']);
    Route::put('/halls/{id}', [HallController::class, 'update']);
    Route::delete('/halls/{id}', [HallController::class, 'destroy']);
});
