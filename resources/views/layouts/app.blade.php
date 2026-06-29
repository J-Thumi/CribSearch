<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle ?? config('app.name', 'CribSearch') }}</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
    
    <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

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
                        accent: "#e74c3c", 
                        bg: "#f5f5f5", 
                        premium: "#c0392b",
                        success: "#27ae60",
                        danger: "#e74c3c", 
                        warning: "#f1c40f", 
                        actionable: "#3498db", 
                        dark: "#000000"
                    },
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f5f5f5; }
        .active-link { color: #b08d57; border-bottom: 2px solid #b08d57; }
    </style>
</head>
<body class="text-dark antialiased">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center gap-2 group">
                        <div class="w-10 h-10 bg-dark rounded-lg flex items-center justify-center text-primary shadow-lg group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-black tracking-tighter text-dark uppercase">
                            {{ config('app.name', 'CribSearch') }}
                        </span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-xs font-bold uppercase tracking-widest {{ request()->is('/') ? 'active-link' : 'text-gray-500 hover:text-primary' }} py-2 transition">Home</a>
                    <a href="{{ route('houses.index') }}" class="text-xs font-bold uppercase tracking-widest {{ request()->routeIs('houses.*') ? 'active-link' : 'text-gray-500 hover:text-primary' }} py-2 transition">Find Houses</a>
                    <!-- <a href="/about" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-primary py-2 transition">About</a> -->
                    <a href="{{url('/admin')}}" class="text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-primary py-2 transition">Agent Portal</a>
                    <a href="/contact" class="px-6 py-3 bg-actionable text-white rounded-lg text-xs font-black uppercase tracking-widest hover:bg-dark shadow-md transition-all duration-300">
                        Contact Support
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-dark hover:text-primary focus:outline-none">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-4 pt-4 pb-8 space-y-2 shadow-xl">
            <a href="/" class="block px-4 py-3 rounded-lg text-sm font-bold uppercase text-dark hover:bg-bg">Home</a>
            <a href="{{ route('houses.index') }}" class="block px-4 py-3 rounded-lg text-sm font-bold uppercase text-dark hover:bg-bg">Find Houses</a>
            <a href="/contact" class="block px-4 py-3 rounded-lg text-sm font-bold uppercase bg-primary text-white text-center mt-4 shadow-lg">Contact Us</a>
        </div>
    </nav>

    <main class="min-h-[80vh]">
        @yield('content')
    </main>

    <footer class="bg-dark text-gray-400 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
                <div>
                    <h3 class="text-primary text-xl font-black uppercase tracking-tighter mb-6">
                        {{ config('app.name', 'CribSearch') }}
                    </h3>
                    <p class="text-sm leading-relaxed font-light">
                        Premium property scouting. Finding your next high-end home shouldn't be a headache. We provide verified listings scouted by professionals.
                    </p>
                </div>
                <div>
                    <h4 class="text-white text-xs font-bold uppercase tracking-widest mb-6">Quick Navigation</h4>
                    <ul class="space-y-4 text-xs font-medium uppercase tracking-wider">
                        <li><a href="{{ route('houses.index') }}" class="hover:text-primary transition">All Listings</a></li>
                        <li><a href="/privacy" class="hover:text-primary transition">Privacy Policy</a></li>
                        <li><a href="/admin" class="text-primary hover:text-white transition">Scout Portal</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs font-bold uppercase tracking-widest mb-6">Connect</h4>
                    <p class="text-sm mb-2">Nairobi, Kenya</p>
                    <p class="text-sm text-actionable font-bold">info@cribsearch.co.ke</p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-16 pt-8 text-center">
                <p class="text-[10px] uppercase tracking-[0.2em] text-gray-600">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. Optimized for Excellence.
                </p>
            </div>
        </div>
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>