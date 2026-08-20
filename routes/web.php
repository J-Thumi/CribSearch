<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BitikaStkPushController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\StkPushController;
use App\Models\House;
// use App\Models\House;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    // Fetch the latest featured/active houses (limit to 6 for the homepage)
    $houses = House::latest()->take(3)->get();

    return view('home', compact('houses'));
});

Route::get('/houses', [HouseController::class, 'index'])->name('houses.index');
Route::get('/houses/{id}', [HouseController::class, 'show'])->name('houses.show');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/me', [AuthController::class, 'me'])
    ->middleware('auth')
    ->name('me');
    
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::view('/terms', 'terms')->name('terms');
Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact');

Route::post('/contact-us', [ContactController::class, 'store'])
    ->name('contact.store');
// Protected routes (Requires Sanctum Bearer Token)

Route::middleware('auth')->post(
    '/houses/{house}/unlock',
    [BitikaStkPushController::class, 'initiateStkPush']
)->name('unlock');

Route::middleware('auth')->get('/n/{token}', [NavigationController::class, 'show'])
    ->name('navigation.show');

Route::post('/navigation/route', [NavigationController::class, 'route'])
    ->name('navigation.route');

Route::get('/test-404', fn() => abort(404));
Route::get('/test-419', fn() => abort(419));
Route::get('/test-500', fn() => abort(500));
Route::get('/test-503', fn() => abort(503));
Route::get('/test-403', fn() => abort(403, 'Unauthorized access to Scout dashboard.'));

// Request Password Reset Link (Email Form)
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Perform Password Reset Form
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');