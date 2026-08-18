<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle ?? config('app.name', 'CribSearch') }}</title>
    
    <!-- External Dependencies -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#b08d57", 
                        accent: "#e74c3c", 
                        bg: "#f8fafc", 
                        premium: "#c0392b",
                        success: "#27ae60",
                        danger: "#e74c3c", 
                        warning: "#f1c40f", 
                        actionable: "#3498db", 
                        dark: "#0f172a"
                    },
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                    },
                    boxShadow: {
                        'subtle': '0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03)',
                        'card': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.08)',
                    }
                }
            }
        }
    </script>

    <style>
        body { 
            font-family: 'Roboto', sans-serif; 
            background-color: #f8fafc; 
            color: #0f172a;
        }
        .active-link { 
            color: #b08d57; 
            font-weight: 700;
            position: relative;
        }
        .active-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #b08d57;
            border-radius: 2px;
        }
    </style>
</head>
<body class="text-dark antialiased selection:bg-primary/20 selection:text-primary flex flex-col min-h-screen">

    <!-- Sticky Glassmorphism Header Bar -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 shadow-sm transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Brand Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center gap-3 group">
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
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex items-center space-x-7">
                    <a href="/" class="text-xs font-bold uppercase tracking-wider {{ request()->is('/') ? 'active-link' : 'text-slate-600 hover:text-primary' }} transition-colors py-1">
                        Home
                    </a>
                    <a href="{{ route('houses.index') }}" class="text-xs font-bold uppercase tracking-wider {{ request()->routeIs('houses.*') ? 'active-link' : 'text-slate-600 hover:text-primary' }} transition-colors py-1">
                        Find Houses
                    </a>
                    <a href="{{ url('/admin') }}" class="text-xs font-bold uppercase tracking-wider text-slate-600 hover:text-primary transition-colors py-1">
                        Agent Portal
                    </a>
                    
                    <div class="h-5 w-px bg-slate-200"></div>

                    <!-- Guest State -->
                    <div id="guest-nav-desktop" class="flex items-center space-x-3">
                        <a href="/login" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-dark hover:text-primary transition-colors">
                            Sign In
                        </a>
                        <a href="/register" class="px-5 py-2.5 bg-primary hover:bg-dark text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-sm hover:shadow transition-all duration-200">
                            Register
                        </a>
                    </div>

                    <!-- Authenticated State -->
                    <div id="auth-nav-desktop" class="hidden items-center space-x-3">
                        <span id="nav-user-name" class="text-xs font-bold uppercase tracking-wider text-primary bg-amber-500/10 px-3.5 py-1.5 rounded-lg border border-amber-500/20">
                            Account
                        </span>
                        <button id="logout-btn-desktop" onclick="handleLogout()" class="px-4 py-2 bg-slate-100 hover:bg-red-600 hover:text-white text-slate-700 rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200">
                            Logout
                        </button>
                    </div>

                    <a href="/contact" class="px-4 py-2.5 bg-actionable/10 text-actionable hover:bg-actionable hover:text-white rounded-xl text-xs font-bold uppercase tracking-wider border border-actionable/20 transition-all duration-200">
                        Support
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="p-2 text-dark hover:text-primary focus:outline-none rounded-lg hover:bg-slate-100 transition-colors" aria-label="Toggle navigation">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-200 px-4 pt-3 pb-6 space-y-2 shadow-xl animate-in slide-in-from-top-2">
            <a href="/" class="block px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-dark hover:bg-slate-50">Home</a>
            <a href="{{ route('houses.index') }}" class="block px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-dark hover:bg-slate-50">Find Houses</a>
            <a href="{{ url('/admin') }}" class="block px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-dark hover:bg-slate-50">Agent Portal</a>
            
            <div class="border-t border-slate-100 my-2 pt-2"></div>

            <!-- Mobile Guest State -->
            <div id="guest-nav-mobile" class="space-y-2">
                <a href="/login" class="block px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-dark hover:bg-slate-50">Sign In</a>
                <a href="/register" class="block px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider bg-primary text-white text-center shadow-sm">Register</a>
            </div>

            <!-- Mobile Auth State -->
            <div id="auth-nav-mobile" class="hidden space-y-2">
                <button id="logout-btn-mobile" onclick="handleLogout()" class="w-full text-center px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider bg-red-600 text-white shadow-sm">
                    Logout
                </button>
            </div>

            <a href="/contact" class="block px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider bg-actionable text-white text-center mt-2 shadow-sm">Contact Support</a>
        </div>
    </nav>

    <!-- Main Dynamic Content -->
    <main class="flex-grow min-h-[80vh]">
        @yield('content')
    </main>

    <!-- Platform Footer -->
    <footer class="bg-dark text-slate-400 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-12">
                
                <!-- Brand Info Column -->
                <div class="md:col-span-5 space-y-4">
                    <a href="/" class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-primary/20 text-primary rounded-lg flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <span class="text-xl font-black uppercase tracking-tight text-white">
                            {{ config('app.name', 'CribSearch') }}
                        </span>
                    </a>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
                        Verified property scouting across Kenya. We eliminate fake viewing fees and offer interactive 360° virtual inspections to make house hunting seamless.
                    </p>
                </div>

                <!-- Navigation Column -->
                <div class="md:col-span-3 space-y-4">
                    <h4 class="text-white text-xs font-bold uppercase tracking-widest">Navigation</h4>
                    <ul class="space-y-2.5 text-xs font-medium tracking-wide">
                        <li><a href="{{ route('houses.index') }}" class="hover:text-primary transition-colors">All Listings</a></li>
                        <li><a href="/privacy" class="hover:text-primary transition-colors">Privacy Policy</a></li>
                        <li><a href="/terms" class="hover:text-primary transition-colors">Terms of Service</a></li>
                        <li><a href="/admin" class="text-primary hover:text-white transition-colors font-bold">Scout Portal Login</a></li>
                    </ul>
                </div>

                <!-- Contact & Support Column -->
                <div class="md:col-span-4 space-y-4">
                    <h4 class="text-white text-xs font-bold uppercase tracking-widest">Contact & Verification</h4>
                    <p class="text-xs text-slate-400">Headquarters in Nairobi & Kiambu County, Kenya.</p>
                    <div class="flex items-center gap-2 pt-1">
                        <svg class="w-4 h-4 text-actionable shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:info@cribsearch.co.ke" class="text-xs text-actionable font-bold hover:underline">
                            info@cribsearch.co.ke
                        </a>
                    </div>
                </div>

            </div>

            <div class="border-t border-slate-800/80 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p class="uppercase tracking-widest text-[10px] text-slate-600">Verified Residential Marketplace</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript Handlers -->
    <script>
    // Mobile menu toggle
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    if (btn && menu) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }

    // Check Sanctum Auth State on page load
    document.addEventListener("DOMContentLoaded", async function() {
        try {
            const response = await fetch('/me', {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                // User is authenticated
                document.getElementById('guest-nav-desktop')?.classList.add('hidden');
                document.getElementById('guest-nav-mobile')?.classList.add('hidden');

                const authDesktop = document.getElementById('auth-nav-desktop');
                const authMobile = document.getElementById('auth-nav-mobile');

                if (authDesktop) {
                    authDesktop.classList.remove('hidden');
                    authDesktop.classList.add('flex');
                }

                if (authMobile) {
                    authMobile.classList.remove('hidden');
                }

                const data = await response.json();
                const nameSpan = document.getElementById('nav-user-name');

                if (nameSpan && data.user) {
                    nameSpan.textContent = data.user.name.split(' ')[0];
                }

            } else if (response.status === 401) {
                // User is not authenticated
                document.getElementById('auth-nav-desktop')?.classList.add('hidden');
                document.getElementById('auth-nav-mobile')?.classList.add('hidden');

                document.getElementById('guest-nav-desktop')?.classList.remove('hidden');
                document.getElementById('guest-nav-mobile')?.classList.remove('hidden');
            }

        } catch (err) {
            console.error('Auth check failed:', err);
        }
    });

    // Logout Handler Function
    async function handleLogout() {
        const token = localStorage.getItem('auth_token');
        
        if (token) {
            try {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
            } catch (err) {
                console.error("Logout request error:", err);
            }
        }

        // Clear local token and redirect to login
        localStorage.removeItem('auth_token');
        window.location.href = '/login';
    }
    </script>
</body>
</html>