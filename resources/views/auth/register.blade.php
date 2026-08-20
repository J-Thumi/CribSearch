{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.auth')

@section('title', 'Create Account')

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

<div class="w-full max-w-md mx-auto px-4 sm:px-0">

    {{-- Main Card --}}
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
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                        />
                    </svg>

                </div>

                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900">
                    Create your account
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Join CribSearch and start finding your next home.
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
                            Registration failed
                        </p>

                        <p
                            id="errorMessage"
                            class="mt-0.5 text-xs leading-5 text-red-600"
                        >
                            Please check your details and try again.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Registration Form --}}
            <form
                id="registerForm"
                class="space-y-5"
                novalidate
            >

                @csrf


                {{-- Full Name --}}
                <div>

                    <label
                        for="name"
                        class="mb-2 block text-sm font-bold text-slate-700"
                    >
                        Full name
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
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>

                        </div>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            autocomplete="name"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-4 text-sm font-medium text-slate-800 outline-none transition-all placeholder:text-slate-400 focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-500/10"
                            placeholder="John Doe"
                        >

                    </div>

                    <p
                        id="nameError"
                        class="mt-1.5 hidden text-xs font-medium text-red-500"
                    ></p>

                </div>


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

                    <label
                        for="password"
                        class="mb-2 block text-sm font-bold text-slate-700"
                    >
                        Password
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
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                />
                            </svg>

                        </div>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="new-password"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-12 text-sm font-medium text-slate-800 outline-none transition-all placeholder:text-slate-400 focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-500/10"
                            placeholder="Create a password"
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition hover:text-amber-600"
                            aria-label="Show password"
                        >

                            <svg
                                id="eyeOpenPassword"
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
                                id="eyeClosedPassword"
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

                    {{-- Password Hint --}}
                    <p class="mt-2 text-[11px] text-slate-400">
                        Use at least 8 characters.
                    </p>

                </div>


                {{-- Confirm Password --}}
                <div>

                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-bold text-slate-700"
                    >
                        Confirm password
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
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                />
                            </svg>

                        </div>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            autocomplete="new-password"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-12 text-sm font-medium text-slate-800 outline-none transition-all placeholder:text-slate-400 focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-500/10"
                            placeholder="Repeat your password"
                        >

                        <button
                            type="button"
                            id="toggleConfirmation"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition hover:text-amber-600"
                            aria-label="Show confirmation password"
                        >

                            <svg
                                id="eyeOpenConfirmation"
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
                                id="eyeClosedConfirmation"
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
                        id="confirmationError"
                        class="mt-1.5 hidden text-xs font-medium text-red-500"
                    ></p>

                </div>


                {{-- Terms Consent --}}
                <div
                    id="consentContainer"
                    class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 transition-all"
                >

                    <div class="flex items-start gap-3">

                        <div class="pt-0.5">

                            <input
                                type="checkbox"
                                id="terms"
                                name="terms"
                                value="1"
                                required
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
                                You must accept the Terms & Conditions and Privacy Policy.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Submit --}}
                <button
                    type="submit"
                    id="submitBtn"
                    class="group !mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-amber-500/20 transition-all hover:bg-amber-600 hover:shadow-amber-500/30 active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-70"
                >

                    <span
                        id="btnText"
                        class="flex items-center gap-2"
                    >

                        Create account

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
                            />

                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
                            />
                        </svg>
                    </span>

                </button>

            </form>


            {{-- Login Link --}}
            <div class="relative my-7">

                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-100"></div>
                </div>

                <div class="relative flex justify-center">

                    <span class="bg-white px-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        Already registered?
                    </span>

                </div>

            </div>


            <a
                href="{{ route('login') }}{{ request('redirect') ? '?redirect=' . urlencode(request('redirect')) : '' }}"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-bold text-slate-700 transition-all hover:border-amber-300 hover:bg-amber-50 hover:text-amber-700"
            >

                Sign in to your account

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
                    Your information is securely protected
                </span>

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('registerForm');

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');

    const passwordInput = document.getElementById('password');
    const confirmationInput = document.getElementById('password_confirmation');

    const termsInput = document.getElementById('terms');

    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');

    const errorAlert = document.getElementById('errorAlert');
    const errorMessage = document.getElementById('errorMessage');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const confirmationError = document.getElementById('confirmationError');
    const termsError = document.getElementById('termsError');

    const consentContainer =
        document.getElementById('consentContainer');


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


    function showFieldError(input, errorElement, message) {

        errorElement.textContent = message;

        errorElement.classList.remove('hidden');

        input.classList.add(
            'border-red-300',
            'focus:border-red-500',
            'focus:ring-red-500/10'
        );
    }


    function clearFieldError(input, errorElement) {

        errorElement.textContent = '';

        errorElement.classList.add('hidden');

        input.classList.remove(
            'border-red-300',
            'focus:border-red-500',
            'focus:ring-red-500/10'
        );
    }


    function clearAllErrors() {

        hideError();

        clearFieldError(nameInput, nameError);
        clearFieldError(emailInput, emailError);
        clearFieldError(passwordInput, passwordError);
        clearFieldError(
            confirmationInput,
            confirmationError
        );

        termsError.classList.add('hidden');

        consentContainer.classList.remove(
            'border-red-300',
            'bg-red-50'
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
    | Password Visibility
    |--------------------------------------------------------------------------
    */

    function setupPasswordToggle(
        input,
        button,
        openIcon,
        closedIcon
    ) {

        button.addEventListener('click', () => {

            const isPassword =
                input.type === 'password';

            input.type =
                isPassword
                    ? 'text'
                    : 'password';

            openIcon.classList.toggle(
                'hidden',
                isPassword
            );

            closedIcon.classList.toggle(
                'hidden',
                !isPassword
            );

            button.setAttribute(
                'aria-label',
                isPassword
                    ? 'Hide password'
                    : 'Show password'
            );
        });
    }


    setupPasswordToggle(
        passwordInput,
        document.getElementById('togglePassword'),
        document.getElementById('eyeOpenPassword'),
        document.getElementById('eyeClosedPassword')
    );


    setupPasswordToggle(
        confirmationInput,
        document.getElementById('toggleConfirmation'),
        document.getElementById('eyeOpenConfirmation'),
        document.getElementById('eyeClosedConfirmation')
    );


    /*
    |--------------------------------------------------------------------------
    | Consent
    |--------------------------------------------------------------------------
    */

    function validateTerms() {

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


    termsInput.addEventListener(
        'change',
        validateTerms
    );


    /*
    |--------------------------------------------------------------------------
    | Clear Field Errors While Typing
    |--------------------------------------------------------------------------
    */

    nameInput.addEventListener('input', () => {

        clearFieldError(
            nameInput,
            nameError
        );

        hideError();
    });


    emailInput.addEventListener('input', () => {

        clearFieldError(
            emailInput,
            emailError
        );

        hideError();
    });


    passwordInput.addEventListener('input', () => {

        clearFieldError(
            passwordInput,
            passwordError
        );

        hideError();
    });


    confirmationInput.addEventListener('input', () => {

        clearFieldError(
            confirmationInput,
            confirmationError
        );

        hideError();
    });


    /*
    |--------------------------------------------------------------------------
    | Form Submission
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', async (event) => {

        event.preventDefault();

        clearAllErrors();


        const name =
            nameInput.value.trim();

        const email =
            emailInput.value.trim();

        const password =
            passwordInput.value;

        const passwordConfirmation =
            confirmationInput.value;


        let valid = true;


        /*
        |--------------------------------------------------------------------------
        | Client-Side Validation
        |--------------------------------------------------------------------------
        */

        if (!name) {

            showFieldError(
                nameInput,
                nameError,
                'Please enter your full name.'
            );

            valid = false;
        }


        if (!email) {

            showFieldError(
                emailInput,
                emailError,
                'Please enter your email address.'
            );

            valid = false;

        } else if (
            !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
        ) {

            showFieldError(
                emailInput,
                emailError,
                'Please enter a valid email address.'
            );

            valid = false;
        }


        if (!password) {

            showFieldError(
                passwordInput,
                passwordError,
                'Please create a password.'
            );

            valid = false;

        } else if (password.length < 8) {

            showFieldError(
                passwordInput,
                passwordError,
                'Your password must be at least 8 characters.'
            );

            valid = false;
        }


        if (!passwordConfirmation) {

            showFieldError(
                confirmationInput,
                confirmationError,
                'Please confirm your password.'
            );

            valid = false;

        } else if (
            password !== passwordConfirmation
        ) {

            showFieldError(
                confirmationInput,
                confirmationError,
                'Passwords do not match.'
            );

            valid = false;
        }


        if (!validateTerms()) {
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

        const params =
            new URLSearchParams(
                window.location.search
            );

        const redirectUrl =
            params.get('redirect');


        /*
        |--------------------------------------------------------------------------
        | Request Payload
        |--------------------------------------------------------------------------
        */

        const payload = {

            name: name,

            email: email,

            password: password,

            password_confirmation:
                passwordConfirmation,

            terms: true
        };


        if (redirectUrl) {

            payload.redirect =
                redirectUrl;
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

            const response =
                await fetch('/register', {

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

                    body:
                        JSON.stringify(payload)
                });


            let data = {};

            try {

                data =
                    await response.json();

            } catch {

                data = {};
            }


            /*
            |--------------------------------------------------------------------------
            | Successful Registration
            |--------------------------------------------------------------------------
            */

            if (response.ok) {

                const redirectTo =
                    data.redirect
                    ||
                    redirectUrl
                    ||
                    '/houses';

                window.location.href =
                    redirectTo;

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Laravel Validation Errors
            |--------------------------------------------------------------------------
            */

            if (data.errors) {

                if (data.errors.name?.length) {

                    showFieldError(
                        nameInput,
                        nameError,
                        data.errors.name[0]
                    );
                }


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


                if (
                    data.errors.password_confirmation?.length
                ) {

                    showFieldError(
                        confirmationInput,
                        confirmationError,
                        data.errors.password_confirmation[0]
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


                const hasFieldErrors =
                    data.errors.name ||
                    data.errors.email ||
                    data.errors.password ||
                    data.errors.password_confirmation ||
                    data.errors.terms;


                if (!hasFieldErrors) {

                    showError(
                        data.message ||
                        'Please check your details and try again.'
                    );
                }

            } else {

                showError(
                    data.message ||
                    'Registration failed. Please try again.'
                );
            }

        } catch (error) {

            console.error(
                'Registration error:',
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