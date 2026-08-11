<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CribSearch — Hunt Smarter. Live Better.</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
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
            success: "#27ae60", // Green for Vacant [cite: 43]
            danger: "#e74c3c",  // Red for Occupied [cite: 44]
            warning: "#f1c40f", // Yellow for Pending [cite: 45]
            actionable: "#3498db", // Blue for UI elements [cite: 86]
            dark: "#000000"
          },
          fontFamily: {
            sans: ['Roboto', 'sans-serif'], // Required typography [cite: 87]
          }
        }
      }
    }
</script>
  <style>
    .map-hero {
      background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('bg.png');
      background-size: cover;
      background-position: center;
    }
    /* Marker Animation from Brief [cite: 141] */
    .animated-pin {
      animation: bounce 2s infinite;
    }
    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
  </style>
</head>
<body class="bg-bg text-gray-800 antialiased">

  <header class="bg-white/90 backdrop-blur-md shadow-sm fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <img src="generated_logoo-removebg-preview.png" width="100" height="100" style="border-radius:50%;">
        <span class="text-2xl font-bold tracking-tight text-primary">CribSearch</span>
      </div>
      <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold uppercase tracking-wider">
        <a href="#features" class="hover:text-accent transition">Discovery</a>
        <a href="#pricing" class="hover:text-accent transition">Premium</a>
        <a href="#" class="hover:text-accent transition">Partners</a>
      </nav>
      <div class="flex items-center gap-4">

        <a href="{{url('/admin')}}"><button class="text-sm font-bold text-gray-600 hover:text-primary transition">Agent Login</button></a>
        <button class="px-5 py-2.5 rounded-full bg-actionable text-white text-sm font-bold shadow-lg hover:bg-blue-600 transition">Explore Map</button>
        <a href="{{ route('houses.index') }}" class="px-5 py-2.5 rounded-full bg-actionable text-white text-sm font-bold shadow-lg hover:bg-blue-600 transition">Explore Homes</a>
         <button class="px-5 py-2.5 rounded-full bg-actionable text-white text-sm font-bold shadow-lg hover:bg-blue-600 transition">Explore Homes</button>
      </div>
    </div>
  </header> -->
@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-dark min-h-[85vh] flex items-center justify-center overflow-hidden">
    <!-- Background Image Overlay with Gradients -->
    <div class="absolute inset-0 z-0 opacity-40 bg-cover bg-center" 
         style="background-image: url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1920&q=80');">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/70 to-transparent z-0"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
        <!-- Pill Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-bold uppercase tracking-widest mb-6">
            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
            Verified Homes & 360° Virtual Tours
        </div>

        <h1 class="text-4xl sm:text-6xl md:text-7xl font-black text-white uppercase tracking-tight max-w-4xl mx-auto leading-none mb-6">
            Find Your Next <span class="text-primary underline decoration-primary/40 underline-offset-8">Dream Crib</span> Without The Stress.
        </h1>
        
        <p class="text-gray-300 text-base sm:text-lg max-w-2xl mx-auto font-light mb-10 leading-relaxed">
            Skip fake listings and unreliable agents. Explore verified residential properties across Kenya with interactive 360° tours and transparent pricing.
        </p>

        <!-- Search Bar Component -->
        <div class="bg-white p-3 sm:p-4 rounded-2xl shadow-2xl max-w-4xl mx-auto border border-white/20">
            <form action="{{ route('houses.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <div class="sm:col-span-4 text-left border-b sm:border-b-0 sm:border-r border-gray-100 pb-2 sm:pb-0 sm:pr-4">
                    <label class="block text-[10px] font-black uppercase text-gray-400 tracking-wider mb-1">Location</label>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <input type="text" name="location" placeholder="Kilimani, Westlands, Ruiru..." 
                            class="w-full bg-transparent text-sm font-medium focus:outline-none text-dark placeholder-gray-400">
                    </div>
                </div>

                <div class="sm:col-span-3 text-left border-b sm:border-b-0 sm:border-r border-gray-100 pb-2 sm:pb-0 sm:pr-4">
                    <label class="block text-[10px] font-black uppercase text-gray-400 tracking-wider mb-1">Type</label>
                    <select name="type" class="w-full bg-transparent text-sm font-medium focus:outline-none text-dark cursor-pointer">
                        <option value="">All Categories</option>
                        <option value="apartment">Apartment</option>
                        <option value="mansionette">Mansionette</option>
                        <option value="studio">Studio / Bedsitter</option>
                        <option value="villa">Luxury Villa</option>
                    </select>
                </div>

                <div class="sm:col-span-3 text-left pb-2 sm:pb-0">
                    <label class="block text-[10px] font-black uppercase text-gray-400 tracking-wider mb-1">Max Price (KES)</label>
                    <input type="number" name="max_price" placeholder="e.g. 50,000" 
                        class="w-full bg-transparent text-sm font-medium focus:outline-none text-dark placeholder-gray-400">
                </div>

                <div class="sm:col-span-2">
                    <button type="submit" 
                        class="w-full h-full min-h-[48px] bg-primary hover:bg-dark text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-md transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Search</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto mt-16 pt-12 border-t border-white/10">
            <div>
                <span class="block text-3xl font-black text-white">500+</span>
                <span class="text-xs uppercase tracking-widest text-primary font-medium">Scouted Properties</span>
            </div>
            <div>
                <span class="block text-3xl font-black text-white">100%</span>
                <span class="text-xs uppercase tracking-widest text-primary font-medium">Verified Agents</span>
            </div>
            <div>
                <span class="block text-3xl font-black text-white">360°</span>
                <span class="text-xs uppercase tracking-widest text-primary font-medium">Virtual Tours</span>
            </div>
            <div>
                <span class="block text-3xl font-black text-white">0</span>
                <span class="text-xs uppercase tracking-widest text-primary font-medium">Viewing Scandals</span>
            </div>
        </div>
    </div>
</div>

<!-- Features / How It Works -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-xs font-black uppercase tracking-[0.3em] text-primary mb-3">Smarter Scouting</h2>
            <h3 class="text-3xl sm:text-4xl font-black uppercase text-dark tracking-tight">Why Choose {{ config('app.name', 'CribSearch') }}</h3>
            <div class="w-12 h-1 bg-primary mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="p-8 rounded-2xl bg-bg border border-gray-100 hover:border-primary/50 transition-all duration-300 group hover:-translate-y-1">
                <div class="w-14 h-14 bg-dark text-primary rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h4 class="text-xl font-black uppercase text-dark mb-3">360° Virtual Inspection</h4>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Walk through bedrooms, kitchens, and living rooms from your phone. Inspect every detail before paying viewing fees.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="p-8 rounded-2xl bg-bg border border-gray-100 hover:border-primary/50 transition-all duration-300 group hover:-translate-y-1">
                <div class="w-14 h-14 bg-dark text-primary rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h4 class="text-xl font-black uppercase text-dark mb-3">100% Verified Listings</h4>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Every property is physically scouted and vetted by authorized agents to guarantee existence, accurate pricing, and water/security checks.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="p-8 rounded-2xl bg-bg border border-gray-100 hover:border-primary/50 transition-all duration-300 group hover:-translate-y-1">
                <div class="w-14 h-14 bg-dark text-primary rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="text-xl font-black uppercase text-dark mb-3">Instant Visit Booking</h4>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Found something you love? Book a direct physical visit with the property scout in just a single click.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Interactive 360 Showcase Section -->
<section class="py-20 bg-dark text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-5 space-y-6">
                <span class="inline-block px-3 py-1 rounded bg-primary/20 text-primary text-xs font-bold uppercase tracking-widest">Interactive Feature</span>
                <h2 class="text-3xl sm:text-4xl font-black uppercase tracking-tight">Experience 360° Virtual Living</h2>
                <p class="text-gray-400 text-sm leading-relaxed font-light">
                    Drag around to explore room interiors interactively. We integrate full panoramic virtual viewing directly into house profiles so you know exactly what you are paying for.
                </p>
                <div class="pt-4">
                    <a href="{{ route('houses.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-white hover:text-dark transition-all duration-300 shadow-lg">
                        <span>Browse 360° Homes</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Pannellum Viewer Container -->
            <div class="lg:col-span-7">
                <div class="relative rounded-2xl overflow-hidden border-2 border-gray-800 shadow-2xl bg-black">
                    <div id="panorama-preview" class="w-full h-[400px]"></div>
                    <div class="absolute bottom-4 left-4 bg-dark/80 backdrop-blur-md px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider text-primary border border-gray-700">
                        Drag mouse or swipe to rotate 360°
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call To Action for House Owners / Agents -->
<section class="py-20 bg-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-dark to-gray-900 rounded-3xl p-8 sm:p-16 text-center relative overflow-hidden shadow-2xl">
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-primary mb-3">For Landlords & Agents</h2>
                <h3 class="text-3xl sm:text-4xl font-black uppercase text-white tracking-tight mb-6">
                    Have a property to list or scout?
                </h3>
                <p class="text-gray-400 text-sm mb-8 leading-relaxed font-light">
                    Join our network of verified scouts and property managers. Get high quality leads and tenant bookings directly to your agent dashboard.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="/admin" class="w-full sm:w-auto px-8 py-4 bg-primary hover:bg-white hover:text-dark text-white rounded-xl font-bold text-xs uppercase tracking-widest transition-all duration-300">
                        Access Agent Portal
                    </a>
                    <a href="/contact" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold text-xs uppercase tracking-widest border border-white/10 transition-all duration-300">
                        Talk To Our Team
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pannellum Tour Initialization Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof pannellum !== 'undefined') {
            pannellum.viewer('panorama-preview', {
                "type": "equirectangular",
                "panorama": "https://pannellum.org/images/alma.jpg", // Demo equirectangular image
                "autoLoad": true,
                "autoRotate": -2,
                "showControls": false
            });
        }
    });
</script>
@endsection