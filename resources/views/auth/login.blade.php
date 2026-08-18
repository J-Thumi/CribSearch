<!-- resources/views/auth/login.blade.php -->
@extends('layouts.auth')

@section('title', 'Sign In')

{{-- Ensure CSRF Meta Tag is present if missing from layouts.auth --}}
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="w-full max-w-md mx-auto">
    <!-- Main Card Container -->
    <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-gray-100 p-8 sm:p-10 relative overflow-hidden transition-all duration-300">
        
        <!-- Top Accent Gradient Line -->
        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-400 via-primary to-amber-600"></div>

        <!-- Card Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-amber-500/10 text-primary mb-4 border border-amber-500/20 shadow-inner">
                <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 font-medium">Access your account and saved properties</p>
        </div>

        <!-- Alert Box for Error Messages -->
        <div id="errorAlert" class="hidden mb-6 p-4 rounded-xl bg-red-50/80 border border-red-200/80 text-xs sm:text-sm text-red-600 font-medium animate-fadeIn flex items-center gap-2.5">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="errorMessage">Invalid credentials. Please try again.</span>
        </div>

        <!-- Login Form -->
        <form id="loginForm" class="space-y-5">
            {{-- Blade CSRF field as fallback --}}
            @csrf

            <!-- Email Input Group -->
            <div>
                <label for="email" class="block text-xs font-extrabold uppercase tracking-wider text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" required
                        class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50/50 border border-gray-200 text-sm font-medium text-gray-800 placeholder-gray-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all duration-200"
                        placeholder="name@example.com">
                </div>
            </div>

            <!-- Password Input Group -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-extrabold uppercase tracking-wider text-gray-700">Password</label>
                    <a href="/password/reset" class="text-xs font-semibold text-amber-600 hover:text-amber-700 transition-colors">Forgot?</a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="w-full pl-11 pr-11 py-3 rounded-xl bg-gray-50/50 border border-gray-200 text-sm font-medium text-gray-800 placeholder-gray-400 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all duration-200"
                        placeholder="••••••••">
                    
                    <button type="button" onclick="togglePasswordVisibility('password', 'eyeIconPassword')" 
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-amber-600 focus:outline-none transition-colors"
                        tabindex="-1"
                        aria-label="Toggle password visibility">
                        <!-- Eye Open Icon -->
                        <svg id="eyeIconPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="submitBtn"
                class="w-full mt-2 py-3.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-amber-500/25 hover:shadow-amber-500/35 active:scale-[0.99] transition-all duration-200 flex items-center justify-center cursor-pointer">
                <span id="btnText" class="flex items-center gap-2">
                    <span>Sign In</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </span>
                <span id="btnSpinner" class="hidden">
                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </form>

        <!-- Footer Redirect -->
        <p class="text-center text-xs text-gray-500 mt-8 pt-6 border-t border-gray-100 font-medium">
            Don't have an account?
            <a
                href="{{ route('register') }}?redirect={{ urlencode(request('redirect', '/houses')) }}"
                class="font-bold text-amber-600 hover:text-amber-700 transition-colors underline-offset-2 hover:underline"
            >
                Create an account
            </a>
        </p>
    </div>
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
        const errorMessage = document.getElementById('errorMessage');

        // UI Loading state
        submitBtn.disabled = true;
        btnText.classList.add('hidden');
        btnSpinner.classList.remove('hidden');
        errorAlert.classList.add('hidden');

        // Extract the 'redirect' param from the current URL if available
        const urlParams = new URLSearchParams(window.location.search);
        const redirectUrl = urlParams.get('redirect') || window.location.href;

        const payload = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            redirect: redirectUrl, // <--- Sends '/houses/111' to backend
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content 
                        || document.querySelector('input[name="_token"]')?.value;

        try {
            await fetch('/sanctum/csrf-cookie', { credentials: 'same-origin' }).catch(() => {});

            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (response.ok) {
                                
                const params = new URLSearchParams(window.location.search);
                const redirectTo = params.get('redirect') || '/houses';

                window.location.href = redirectTo;
            } else {
                const message = data.message || 'Invalid credentials. Please try again.';
                if (typeof errorMessage !== 'undefined' && errorMessage) {
                    errorMessage.textContent = message;
                } else if (typeof errorAlert !== 'undefined' && errorAlert) {
                    errorAlert.textContent = message;
                    errorAlert.classList.remove('hidden');
                }
            }
        } catch (err) {
            const message = 'A network error occurred. Please try again later.';
            if (typeof errorAlert !== 'undefined' && errorAlert) {
                errorAlert.textContent = message;
                errorAlert.classList.remove('hidden');
            }
        }
    });
</script>
@endsection