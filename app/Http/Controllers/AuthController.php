<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user and log them into the web session.
     */
    public function register(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms'    => ['accepted'],
            'redirect' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name'              => $fields['name'],
            'email'             => $fields['email'],
            'password'          => Hash::make($fields['password']),
            'is_admin'          => false,
            'terms_accepted_at' => now(),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        $redirect = $request->input('redirect');

        if (
            !$redirect ||
            !str_starts_with($redirect, '/')
        ) {
            $redirect = route('houses.index');
        }

        return response()->json([
            'message'  => 'User registered successfully',
            'user'     => $user,
            'redirect' => $redirect,
        ], 201);
    }

    /**
     * Authenticate user using the Laravel web session.
     */
    public function login(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'terms'    => ['accepted'],
            'redirect' => ['nullable', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        if (!Auth::attempt([
            'email'    => $fields['email'],
            'password' => $fields['password'],
        ], $request->boolean('remember'))) {

            throw ValidationException::withMessages([
                'email' => [
                    'The provided credentials do not match our records.'
                ],
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        /*
        * Record the date/time the user accepted
        * the current Terms & Conditions.
        */
        if ($request->boolean('terms') && !$user->terms_accepted_at) {
            $user->update([
                'terms_accepted_at' => now(),
            ]);
        }

        /*
        * Only allow local redirects.
        */
        $redirectTarget = $request->input('redirect');

        if (
            !$redirectTarget ||
            !str_starts_with($redirectTarget, '/')
        ) {
            $redirectTarget =
                session()->pull('url.intended')
                ?? route('houses.index');
        }

        return response()->json([
            'message'  => 'Logged in successfully',
            'user'     => $user,
            'redirect' => $redirectTarget,
        ]);
    }

    /**
     * Log the user out of the web session.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Fetch the currently authenticated user.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}