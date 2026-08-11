<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\StkPushController;
// use App\Models\House;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/houses', [HouseController::class, 'index'])->name('houses.index');
Route::get('/houses/{id}', [HouseController::class, 'show'])->name('houses.show');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');


// Protected routes (Requires Sanctum Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/unlock', [StkPushController::class, 'initiateStkPush'])->name('unlock');

});