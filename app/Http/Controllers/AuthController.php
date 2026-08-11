<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user and return an API token.
     */
    public function register(Request $request): JsonResponse
    {
        Log::info('Registering new user', ['email' => $request->input('email')]);

        $fields = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $fields['name'],
            'email'    => $fields['email'],
            'password' => Hash::make($fields['password']),
            'is_admin' => $request->input('is_admin', false), // Default to false if not provided
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'      => 'User registered successfully',
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 201);
    }

    /**
     * Authenticate user and issue a new token.
     */
    public function login(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        // Optional: revoke existing tokens before creating a new one
        // $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'      => 'Logged in successfully',
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 200);
    }

    /**
     * Revoke current access token (Logout).
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }

    /**
     * Fetch authenticated user details.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ], 200);
    }
}