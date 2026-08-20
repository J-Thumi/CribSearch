<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Set New Password | {{ config('app.name', 'CribSearch') }}</title>

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
                        dark: "#0f172a"
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-black text-dark uppercase tracking-tight">Set New Password</h1>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Choose a strong password with at least 8 characters.
                </p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-[10px] font-extrabold uppercase text-slate-400 tracking-wider mb-1.5">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                        class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 cursor-not-allowed">
                    @error('email')
                        <p class="text-red-500 text-[11px] font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-[10px] font-extrabold uppercase text-slate-400 tracking-wider mb-1.5">
                        New Password
                    </label>
                    <input id="password" type="password" name="password" required autofocus
                        placeholder="••••••••"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-dark focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-200 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-[11px] font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="block text-[10px] font-extrabold uppercase text-slate-400 tracking-wider mb-1.5">
                        Confirm New Password
                    </label>
                    <input id="password-confirm" type="password" name="password_confirmation" required
                        placeholder="••••••••"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-dark focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-200">
                </div>

                <button type="submit" 
                    class="w-full py-3 px-4 bg-primary hover:bg-dark text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-md hover:shadow-lg transition-all duration-200">
                    Update Password
                </button>
            </form>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-[11px] text-slate-400 border-t border-slate-200/60">
        &copy; {{ date('Y') }} {{ config('app.name', 'CribSearch') }}. All rights reserved.
    </footer>

</body>
</html>