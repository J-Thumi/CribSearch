<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StkPushController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/webhooks/bitika', [App\Http\Controllers\BitikaWebhookController::class, 'handle']);
Route::post('/webhooks/blink', [App\Http\Controllers\BlinkWebhookController::class, 'handle']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (Requires Sanctum Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/unlock', [StkPushController::class, 'initiateStkPush'])->name('unlock');
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});