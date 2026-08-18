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
        Log::info('Registering new user', [
            'email' => $request->input('email'),
        ]);

        $fields = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $fields['name'],
            'email'    => $fields['email'],
            'password' => Hash::make($fields['password']),
            'is_admin' => false,
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        $redirect = $request->input('redirect');

        if (!$redirect || !str_starts_with($redirect, '/')) {
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
            'redirect' => ['nullable', 'string'],
        ]);

        if (!Auth::attempt([
            'email'    => $fields['email'],
            'password' => $fields['password'],
        ])) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        // Prevent session fixation
        $request->session()->regenerate();

        // Prioritize the explicitly passed redirect URL, then session intended, then fallback
        $redirectTarget = $request->input('redirect') 
            ?? session()->pull('url.intended') 
            ?? route('houses.index');

        return response()->json([
            'message'  => 'Logged in successfully',
            'user'     => Auth::user(),
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