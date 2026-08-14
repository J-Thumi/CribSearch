<!-- resources/views/auth/login.blade.php -->
@extends('layouts.auth')

@section('title', 'Sign In')

{{-- Step 1: Ensure CSRF Meta Tag is present if missing from layouts.auth --}}
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-amber-100 p-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-amber-500 text-white mb-4 shadow-md shadow-amber-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
        <p class="text-sm text-gray-500 mt-1">Please enter your credentials to sign in</p>
    </div>

    <!-- Alert Box for Error Messages -->
    <div id="errorAlert" class="hidden mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-600"></div>

    <!-- Login Form -->
    <form id="loginForm" class="space-y-5">
        {{-- Step 2: Include Blade CSRF field as fallback --}}
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input type="email" id="email" name="email" required
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all text-gray-800 placeholder-gray-400"
                placeholder="you@example.com">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
                <input type="password" id="password" name="password" required
                    class="w-full pl-4 pr-11 py-2.5 rounded-xl border border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all text-gray-800 placeholder-gray-400"
                    placeholder="••••••••">
                
                <button type="button" onclick="togglePasswordVisibility('password', 'eyeIconPassword')" 
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-amber-600 focus:outline-none transition-colors"
                    tabindex="-1">
                    <!-- Eye Open Icon -->
                    <svg id="eyeIconPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" id="submitBtn"
            class="w-full py-3 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-medium shadow-lg shadow-amber-500/25 transition-all hover:shadow-amber-500/35 active:scale-[0.99] flex items-center justify-center">
            <span id="btnText">Sign In</span>
            <span id="btnSpinner" class="hidden">
                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        </button>
    </form>

    <!-- Footer Redirect -->
    <p class="text-center text-sm text-gray-500 mt-8">
        Don't have an account?
        <a href="/register" class="font-semibold text-amber-600 hover:text-amber-700">Create account</a>
    </p>
</div>

<script>
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        const eyeOpenPath = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;

        const eyeClosedPath = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.02 10.02 0 014.122-.963c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/>
        `;

        icon.innerHTML = isPassword ? eyeClosedPath : eyeOpenPath;
    }

document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');
    const errorAlert = document.getElementById('errorAlert');

    // UI Loading state
    submitBtn.disabled = true;
    btnText.classList.add('hidden');
    btnSpinner.classList.remove('hidden');
    errorAlert.classList.add('hidden');

    const payload = {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
    };

    // Grab CSRF token from the meta tag or form input
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content 
                     || document.querySelector('input[name="_token"]')?.value;

    try {
        // Optional: If using Sanctum CSRF protection, fetch cookie first
        await fetch('/sanctum/csrf-cookie', { credentials: 'same-origin' }).catch(() => {});

        const response = await fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken // Pass the CSRF Token header
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (response.ok) {
            if (data.access_token) {
                localStorage.setItem('auth_token', data.access_token);
            }
            
            const redirectTo = '/houses';
            window.location.href = redirectTo;

        } else {
            errorAlert.textContent = data.message || 'Invalid credentials. Please try again.';
            errorAlert.classList.remove('hidden');
        }
    } catch (err) {
        errorAlert.textContent = 'A network error occurred. Please try again later.';
        errorAlert.classList.remove('hidden');
    } finally {
        submitBtn.disabled = false;
        btnText.classList.remove('hidden');
        btnSpinner.classList.add('hidden');
    }
});
</script>
@endsection