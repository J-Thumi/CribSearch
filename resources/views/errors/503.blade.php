<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance | {{ config('app.name', 'CribSearch') }}</title>
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
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-dark rounded-xl flex items-center justify-center text-primary shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <span class="text-xl font-black tracking-tight text-dark uppercase leading-none">{{ config('app.name', 'CribSearch') }}</span>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full text-center space-y-6">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-primary/10 text-primary rounded-3xl">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="space-y-2">
                <span class="text-xs font-black tracking-widest uppercase text-primary">System Maintenance</span>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-dark uppercase">We'll Be Right Back</h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed pt-1">
                    CribSearch is currently undergoing scheduled platform improvements to enhance property scouting performance.
                </p>
            </div>
        </div>
    </main>

    <footer class="py-6 text-center text-[11px] text-slate-400 border-t border-slate-200/60">
        &copy; {{ date('Y') }} {{ config('app.name', 'CribSearch') }}. All rights reserved.
    </footer>
</body>
</html>