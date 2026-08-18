<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IntaSendWebhookController;
use App\Http\Controllers\StkPushController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/webhooks/bitika', [App\Http\Controllers\BitikaWebhookController::class, 'handle']);
Route::post('/webhooks/blink', [App\Http\Controllers\BlinkWebhookController::class, 'handle']);
Route::post('/intasend/webhook', [IntaSendWebhookController::class, 'handle'])->name('intasend.webhook');
