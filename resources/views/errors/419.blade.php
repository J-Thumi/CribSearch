<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>419 - Session Expired | {{ config('app.name', 'CribSearch') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: "#b08d57", bg: "#f8fafc", dark: "#0f172a" },
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
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-500/10 text-blue-600 rounded-3xl">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="space-y-2">
                <span class="text-xs font-black tracking-widest uppercase text-blue-600">Error 419</span>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-dark uppercase">Page Session Expired</h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed pt-1">
                    Your session timed out due to inactivity. Please refresh the page and try submitting your request again.
                </p>
            </div>
            <div class="pt-2">
                <button onclick="window.location.reload()" class="px-6 py-3 bg-primary hover:bg-dark text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-md">
                    Refresh Page & Retry
                </button>
            </div>
        </div>
    </main>

    <footer class="py-6 text-center text-[11px] text-slate-400 border-t border-slate-200/60">
        &copy; {{ date('Y') }} {{ config('app.name', 'CribSearch') }}. Verified Residential Marketplace.
    </footer>
</body>
</html>