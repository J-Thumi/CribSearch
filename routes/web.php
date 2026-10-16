<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BitikaStkPushController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\StkPushController;
use App\Http\Controllers\TikTokAuthController;
use App\Models\House;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
// use App\Models\House;
use Illuminate\Support\Facades\Route;
Route::get('/', function (Request $request) {
    $query = House::with('scout');

        // 1. Location Filter (Matches the form's "location" input)
        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where(function ($q) use ($location) {
                $q->where('approximate_area', 'like', "%{$location}%")
                ->orWhere('nearest_gate', 'like', "%{$location}%")
                ->orWhere('name', 'like', "%{$location}%");
            });
        }

        // 2. Type/Size Filter (Matches the form's "type" select input)
        if ($request->filled('type')) {
            $type = $request->input('type');
            // Filters JSON array where any unit object has a matching "size"
            $query->whereJsonContains('units', [['size' => $type]]);
        }

        // 3. Max Price Filter (Matches units where at least one unit price <= max_price)
        if ($request->filled('max_price')) {
            $maxPrice = (float) $request->input('max_price');

            // Works on MySQL 5.7+ & MariaDB 10.2+ using JSON_TABLE or JSON_UNQUOTE
            $query->whereRaw("
                EXISTS (
                    SELECT 1 
                    FROM JSON_TABLE(units, '$[*]' COLUMNS (price FLOAT PATH '$.price')) AS u 
                    WHERE u.price <= ?
                )
            ", [$maxPrice]);
        }

        // Legacy/Alternative query parameters (Retained for backwards compatibility)
        if ($request->filled('scout')) {
            $query->where('scout_id', $request->input('scout'));
        }

        if ($request->filled('gate')) {
            $query->where('nearest_gate', $request->input('gate'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('nearest_gate', 'like', "%{$search}%")
                ->orWhere('approximate_area', 'like', "%{$search}%");
            });
        }

        // Fetch paginated results and append search queries to pagination links
        // $houses = $query->latest()->paginate(9)->withQueryString();

        // Generate or retrieve a consistent seed for the user's session
        $seed = session()->remember('house_seed', function () {
            return rand(1, 10000);
        });

        // seed instead of latest()
        $houses = $query->inRandomOrder($seed)->paginate(9)->withQueryString();

        $gates = House::whereNotNull('nearest_gate')
            ->distinct()
            ->pluck('nearest_gate');

        return view('home', compact('houses', 'gates'));
})->name('home');

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


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get(
    '/email/verify/{id}/{hash}',
    [EmailVerificationController::class, 'verify']
)->middleware('signed')->name('verification.verify');

Route::view('/email/verified', 'auth.email-verified')
    ->middleware('auth')
    ->name('verification.success');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware(['auth'])->group(function () {
    Route::get('/auth/tiktok/redirect', [TikTokAuthController::class, 'redirect'])->name('tiktok.redirect');
    Route::get('/auth/tiktok/callback', [TikTokAuthController::class, 'callback'])->name('tiktok.callback');
});