<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Property Not Found | {{ config('app.name', 'CribSearch') }}</title>

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

    <!-- Header / Brand -->
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full flex items-center justify-between">
        <a href="/" class="flex items-center gap-3 group">
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

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full text-center space-y-6">
            
            <div class="inline-flex items-center justify-center w-20 h-20 bg-primary/10 text-primary rounded-3xl mb-2">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0v-5a1 1 0 011-1h2a1 1 0 011 1v5"/>
                </svg>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-black tracking-widest uppercase text-primary">Error 404</span>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-dark uppercase">Property Not Found</h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed pt-1">
                    The house listing or page you're looking for was moved, unlisted, or no longer exists on CribSearch.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center pt-2">
                <a href="{{ route('houses.index') }}" 
                   class="px-5 py-3 bg-primary hover:bg-dark text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-md transition-all duration-200">
                    Browse All Houses
                </a>
                <a href="/" 
                   class="px-5 py-3 bg-white hover:bg-slate-50 text-dark border border-slate-200 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200">
                    Go to Homepage
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-[11px] text-slate-400 border-t border-slate-200/60">
        &copy; {{ date('Y') }} {{ config('app.name', 'CribSearch') }}. Verified Residential Marketplace.
    </footer>

</body>
</html>