<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server Error | {{ config('app.name', 'CribSearch') }}</title>

    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: "#b08d57", bg: "#f8fafc", dark: "#0f172a", danger: "#e74c3c" },
                    fontFamily: { sans: ['Roboto', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-bg text-dark font-sans min-h-screen flex flex-col justify-between selection:bg-primary/20 selection:text-primary">

    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
        <a href="/" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-dark rounded-xl flex items-center justify-center text-primary shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <span class="text-xl font-black tracking-tight text-dark uppercase leading-none">{{ config('app.name', 'CribSearch') }}</span>
        </a>
    </header>

    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full text-center space-y-6">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-amber-500/10 text-amber-600 rounded-3xl">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="space-y-2">
                <span class="text-xs font-black tracking-widest uppercase text-amber-600">Error 500</span>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-dark uppercase">Something Went Wrong</h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed pt-1">
                    We hit an unexpected system issue while loading this property data. Our engineering team has been notified.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 justify-center pt-2">
                <button onclick="window.location.reload()" class="px-5 py-3 bg-primary hover:bg-dark text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200">
                    Try Reloading Page
                </button>
                <a href="/" class="px-5 py-3 bg-white hover:bg-slate-50 text-dark border border-slate-200 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200">
                    Return Home
                </a>
            </div>
        </div>
    </main>

    <footer class="py-6 text-center text-[11px] text-slate-400 border-t border-slate-200/60">
        &copy; {{ date('Y') }} {{ config('app.name', 'CribSearch') }}. All rights reserved.
    </footer>
</body>
</html>