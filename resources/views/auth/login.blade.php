@extends('layouts.auth')

@section('title', 'Sign In')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

<div class="w-full max-w-md mx-auto px-4 sm:px-0">

    {{-- Login Card --}}
    <div class="relative overflow-hidden rounded-[2rem] bg-white shadow-xl shadow-slate-200/60 border border-slate-100">

        {{-- Top Accent --}}
        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-amber-400 via-amber-500 to-orange-500"></div>

        <div class="p-7 sm:p-9">

            {{-- Header --}}
            <div class="text-center mb-8">

                <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 border border-amber-100">

                    <svg
                        class="h-7 w-7 text-amber-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                        />
                    </svg>

                </div>

                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900">
                    Welcome back
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Sign in to continue finding your next home.
                </p>

            </div>


            {{-- Error Alert --}}
            <div
                id="errorAlert"
                role="alert"
                aria-live="polite"
                class="hidden mb-6 rounded-2xl border border-red-100 bg-red-50 px-4 py-3.5"
            >

                <div class="flex items-start gap-3">

                    <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-red-100">

                        <svg
                            class="h-4 w-4 text-red-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>

                    </div>

                    <div class="min-w-0">

                        <p class="text-sm font-bold text-red-800">
                            Sign in failed
                        </p>

                        <p
                            id="errorMessage"
                            class="mt-0.5 text-xs leading-5 text-red-600"
                        >
                            Invalid credentials. Please try again.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Login Form --}}
            <form id="loginForm" class="space-y-5" novalidate>

                @csrf


                {{-- Email --}}
                <div>

                    <label
                        for="email"
                        class="mb-2 block text-sm font-bold text-slate-700"
                    >
                        Email address
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                            <svg
                                class="h-5 w-5 text-slate-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                                />
                            </svg>

                        </div>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            autocomplete="email"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-4 text-sm font-medium text-slate-800 outline-none transition-all placeholder:text-slate-400 focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-500/10"
                            placeholder="you@example.com"
                        >

                    </div>

                    <p
                        id="emailError"
                        class="mt-1.5 hidden text-xs font-medium text-red-500"
                    ></p>

                </div>


                {{-- Password --}}
                <div>

                    <div class="mb-2 flex items-center justify-between">

                        <label
                            for="password"
                            class="text-sm font-bold text-slate-700"
                        >
                            Password
                        </label>

                        <a
                            href="/password/reset"
                            class="text-xs font-bold text-amber-600 transition hover:text-amber-700"
                        >
                            Forgot password?
                        </a>

                    </div>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                            <svg
                                class="h-5 w-5 text-slate-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                />
                            </svg>

                        </div>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="current-password"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-12 text-sm font-medium text-slate-800 outline-none transition-all placeholder:text-slate-400 focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-500/10"
                            placeholder="Enter your password"
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition hover:text-amber-600"
                            aria-label="Show password"
                        >

                            <svg
                                id="eyeOpen"
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                />
                            </svg>


                            <svg
                                id="eyeClosed"
                                class="hidden h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M3 3l18 18M10.6 10.6a2 2 0 002.8 2.8M9.9 5.2A9.8 9.8 0 0112 5c4.48 0 8.27 2.94 9.54 7a9.9 9.9 0 01-3.03 4.32M6.18 6.18A9.93 9.93 0 002.46 12c1.27 4.06 5.06 7 9.54 7 1.52 0 2.95-.36 4.22-1"
                                />
                            </svg>

                        </button>

                    </div>

                    <p
                        id="passwordError"
                        class="mt-1.5 hidden text-xs font-medium text-red-500"
                    ></p>

                </div>


                {{-- Consent --}}
                <div
                    id="consentContainer"
                    class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 transition-all"
                >

                    <div class="flex items-start gap-3">

                        <div class="flex h-5 items-center">

                            <input
                                type="checkbox"
                                id="terms"
                                name="terms"
                                value="1"
                                class="h-4 w-4 cursor-pointer rounded border-slate-300 text-amber-500 focus:ring-amber-500"
                            >

                        </div>

                        <div class="min-w-0">

                            <label
                                for="terms"
                                class="cursor-pointer text-xs leading-5 text-slate-600"
                            >
                                I agree to the
                                <a
                                    href="{{ route('terms') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="font-bold text-amber-600 hover:text-amber-700 hover:underline"
                                >
                                    Terms & Conditions
                                </a>
                                and
                                <a
                                    href="{{ route('privacy') }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="font-bold text-amber-600 hover:text-amber-700 hover:underline"
                                >
                                    Privacy Policy
                                </a>.
                            </label>

                            <p
                                id="termsError"
                                class="mt-1.5 hidden text-xs font-semibold text-red-500"
                            >
                                You must accept the Terms & Conditions and Privacy Policy to continue.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Remember Me --}}
                <div class="flex items-center pt-1">

                    <label class="flex cursor-pointer items-center gap-2.5">

                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="h-4 w-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500"
                        >

                        <span class="text-xs font-medium text-slate-500">
                            Remember me
                        </span>

                    </label>

                </div>


                {{-- Submit --}}
                <button
                    type="submit"
                    id="submitBtn"
                    class="group flex w-full items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-amber-500/20 transition-all hover:bg-amber-600 hover:shadow-amber-500/30 active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-70"
                >

                    <span
                        id="btnText"
                        class="flex items-center gap-2"
                    >
                        Sign in

                        <svg
                            class="h-4 w-4 transition-transform group-hover:translate-x-0.5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"
                            />
                        </svg>

                    </span>

                    <span
                        id="btnSpinner"
                        class="hidden"
                    >
                        <svg
                            class="h-5 w-5 animate-spin"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>

                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
                            ></path>
                        </svg>
                    </span>

                </button>

            </form>


            {{-- Divider --}}
            <div class="relative my-7">

                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-100"></div>
                </div>

                <div class="relative flex justify-center">

                    <span class="bg-white px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        New to CribSearch?
                    </span>

                </div>

            </div>


            {{-- Register --}}
            <a
                href="{{ route('register') }}?redirect={{ urlencode(request('redirect', '/houses')) }}"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-bold text-slate-700 transition-all hover:border-amber-300 hover:bg-amber-50 hover:text-amber-700"
            >

                Create an account

                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M9 5l7 7-7 7"
                    />
                </svg>

            </a>


            {{-- Security Note --}}
            <div class="mt-6 flex items-center justify-center gap-2">

                <svg
                    class="h-4 w-4 text-emerald-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                    />
                </svg>

                <span class="text-[11px] font-medium text-slate-400">
                    Your account information is securely protected
                </span>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('loginForm');

    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const termsInput = document.getElementById('terms');

    const submitBtn = document.getElementById('submitBtn');

    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');

    const errorAlert = document.getElementById('errorAlert');
    const errorMessage = document.getElementById('errorMessage');

    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const termsError = document.getElementById('termsError');

    const consentContainer = document.getElementById('consentContainer');

    const togglePassword = document.getElementById('togglePassword');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');


    /*
    |--------------------------------------------------------------------------
    | Password Visibility
    |--------------------------------------------------------------------------
    */

    togglePassword.addEventListener('click', () => {

        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword ? 'text' : 'password';

        eyeOpen.classList.toggle('hidden', isPassword);
        eyeClosed.classList.toggle('hidden', !isPassword);

        togglePassword.setAttribute(
            'aria-label',
            isPassword ? 'Hide password' : 'Show password'
        );
    });


    /*
    |--------------------------------------------------------------------------
    | Error Helpers
    |--------------------------------------------------------------------------
    */

    function showError(message) {

        errorMessage.textContent = message;

        errorAlert.classList.remove('hidden');
    }


    function hideError() {

        errorAlert.classList.add('hidden');
    }


    function showFieldError(input, element, message) {

        element.textContent = message;

        element.classList.remove('hidden');

        input.classList.add(
            'border-red-300',
            'focus:border-red-500',
            'focus:ring-red-500/10'
        );
    }


    function clearFieldErrors() {

        emailError.textContent = '';
        passwordError.textContent = '';

        emailError.classList.add('hidden');
        passwordError.classList.add('hidden');

        emailInput.classList.remove(
            'border-red-300',
            'focus:border-red-500',
            'focus:ring-red-500/10'
        );

        passwordInput.classList.remove(
            'border-red-300',
            'focus:border-red-500',
            'focus:ring-red-500/10'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Loading State
    |--------------------------------------------------------------------------
    */

    function setLoading(loading) {

        submitBtn.disabled = loading;

        if (loading) {

            btnText.classList.add('hidden');

            btnSpinner.classList.remove('hidden');

        } else {

            btnText.classList.remove('hidden');

            btnSpinner.classList.add('hidden');
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Consent Validation
    |--------------------------------------------------------------------------
    */

    function validateConsent() {

        if (!termsInput.checked) {

            termsError.classList.remove('hidden');

            consentContainer.classList.add(
                'border-red-300',
                'bg-red-50'
            );

            return false;
        }

        termsError.classList.add('hidden');

        consentContainer.classList.remove(
            'border-red-300',
            'bg-red-50'
        );

        return true;
    }


    termsInput.addEventListener('change', () => {

        validateConsent();

        if (termsInput.checked) {
            hideError();
        }
    });


    /*
    |--------------------------------------------------------------------------
    | Clear Errors While Typing
    |--------------------------------------------------------------------------
    */

    emailInput.addEventListener('input', () => {

        emailError.classList.add('hidden');

        emailInput.classList.remove(
            'border-red-300',
            'focus:border-red-500',
            'focus:ring-red-500/10'
        );

        hideError();
    });


    passwordInput.addEventListener('input', () => {

        passwordError.classList.add('hidden');

        passwordInput.classList.remove(
            'border-red-300',
            'focus:border-red-500',
            'focus:ring-red-500/10'
        );

        hideError();
    });


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', async (event) => {

        event.preventDefault();

        hideError();

        clearFieldErrors();

        /*
        |--------------------------------------------------------------------------
        | Client-Side Validation
        |--------------------------------------------------------------------------
        */

        const email = emailInput.value.trim();
        const password = passwordInput.value;

        let valid = true;


        if (!email) {

            showFieldError(
                emailInput,
                emailError,
                'Please enter your email address.'
            );

            valid = false;
        }


        if (!password) {

            showFieldError(
                passwordInput,
                passwordError,
                'Please enter your password.'
            );

            valid = false;
        }


        if (!validateConsent()) {
            valid = false;
        }


        if (!valid) {
            return;
        }


        setLoading(true);


        /*
        |--------------------------------------------------------------------------
        | Preserve Redirect
        |--------------------------------------------------------------------------
        */

        const params = new URLSearchParams(
            window.location.search
        );

        const redirectUrl = params.get('redirect');


        /*
        |--------------------------------------------------------------------------
        | Request Payload
        |--------------------------------------------------------------------------
        */

        const payload = {

            email: email,

            password: password,

            terms: true,

            remember:
                document.getElementById('remember').checked
        };


        if (redirectUrl) {
            payload.redirect = redirectUrl;
        }


        /*
        |--------------------------------------------------------------------------
        | CSRF
        |--------------------------------------------------------------------------
        */

        const csrfToken =
            document.querySelector(
                'meta[name="csrf-token"]'
            )?.content
            ||
            document.querySelector(
                'input[name="_token"]'
            )?.value;


        try {

            const response = await fetch('/login', {

                method: 'POST',

                credentials: 'same-origin',

                headers: {

                    'Content-Type':
                        'application/json',

                    'Accept':
                        'application/json',

                    'X-CSRF-TOKEN':
                        csrfToken,

                    'X-Requested-With':
                        'XMLHttpRequest'
                },

                body: JSON.stringify(payload)
            });


            let data = {};

            try {

                data = await response.json();

            } catch {

                data = {};
            }


            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            if (response.ok) {

                const redirectTo =
                    data.redirect
                    ||
                    redirectUrl
                    ||
                    '/houses';

                window.location.href = redirectTo;

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Laravel Validation Errors
            |--------------------------------------------------------------------------
            */

            if (data.errors) {

                if (data.errors.email?.length) {

                    showFieldError(
                        emailInput,
                        emailError,
                        data.errors.email[0]
                    );
                }


                if (data.errors.password?.length) {

                    showFieldError(
                        passwordInput,
                        passwordError,
                        data.errors.password[0]
                    );
                }


                if (data.errors.terms?.length) {

                    termsError.textContent =
                        data.errors.terms[0];

                    termsError.classList.remove(
                        'hidden'
                    );

                    consentContainer.classList.add(
                        'border-red-300',
                        'bg-red-50'
                    );
                }


                if (
                    !data.errors.email &&
                    !data.errors.password &&
                    !data.errors.terms
                ) {

                    showError(
                        data.message
                        ||
                        'Please check your details and try again.'
                    );
                }

            } else {

                showError(
                    data.message
                    ||
                    'The email or password is incorrect.'
                );
            }

        } catch (error) {

            console.error(
                'Login error:',
                error
            );

            showError(
                'Unable to connect to the server. Please check your internet connection and try again.'
            );

        } finally {

            setLoading(false);
        }
    });

});
</script>

@endsection

