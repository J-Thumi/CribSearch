<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password | {{ config('app.name', 'CribSearch') }}</title>

    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#b08d57",
                        bg: "#f8fafc",
                        dark: "#0f172a",
                        success: "#27ae60"
                    },
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-bg text-dark font-sans min-h-screen flex flex-col justify-between selection:bg-primary/20 selection:text-primary">

    <!-- Header -->
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
        <a href="/" class="flex items-center gap-3 group inline-flex">
            <div class="w-10 h-10 bg-dark rounded-xl flex items-center justify-center text-primary shadow-md group-hover:bg-primary group-hover:text-white transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-black tracking-tight text-dark uppercase leading-none">
                    {{ config('app.name', 'CribSearch') }}
                </span>
                <span class="text-[9px] font-bold text-primary tracking-widest uppercase mt-0.5">Verified Homes</span>
            </div>
        </a>
    </header>

    <!-- Main Card -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full bg-white p-6 sm:p-8 rounded-2xl shadow-xl border border-slate-200/80 space-y-6">
            
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-primary/10 text-primary rounded-2xl mb-1">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-black text-dark uppercase tracking-tight">Forgot Password?</h1>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Enter your account email address and we'll send you a link to reset your password.
                </p>
            </div>

            <!-- Status Message -->
            @if (session('status'))
                <div class="p-3.5 bg-green-50 border border-green-200 text-green-700 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-[10px] font-extrabold uppercase text-slate-400 tracking-wider mb-1.5">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="you@example.com"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-dark focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-200 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-[11px] font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full py-3 px-4 bg-primary hover:bg-dark text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-md hover:shadow-lg transition-all duration-200">
                    Send Reset Link
                </button>
            </form>

            <div class="text-center pt-2 border-t border-slate-100">
                <a href="/login" class="text-xs font-bold text-slate-500 hover:text-primary transition-colors uppercase tracking-wider">
                    &larr; Back to Sign In
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-[11px] text-slate-400 border-t border-slate-200/60">
        &copy; {{ date('Y') }} {{ config('app.name', 'CribSearch') }}. All rights reserved.
    </footer>

</body>
</html>