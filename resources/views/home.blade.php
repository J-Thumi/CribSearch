@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-dark min-h-[85vh] flex items-center justify-center overflow-hidden">
    <!-- Background Image Overlay with Gradients -->
    <div class="absolute inset-0 z-0 opacity-35 bg-cover bg-center scale-105 transform transition-transform duration-1000" 
         style="background-image: url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1920&q=80');">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/80 to-transparent z-0"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-transparent via-dark/40 to-dark/90 z-0"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20 lg:py-28">
        <!-- Pill Badge -->
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-white text-xs font-semibold uppercase tracking-widest mb-8 shadow-xl">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
            </span>
            <span class="text-gray-200">Verified Homes & 360° Virtual Tours</span>
        </div>

        <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight max-w-5xl mx-auto leading-[1.1] mb-6">
            Find Your Next <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-amber-200 to-primary">Dream Crib</span> Without The Stress.
        </h1>
        
        <p class="text-gray-300 text-base sm:text-lg max-w-2xl mx-auto font-normal mb-12 leading-relaxed opacity-90">
            Skip fake listings and unreliable agents. Explore verified residential properties across Kenya with interactive 360° tours and transparent pricing.
        </p>

        <!-- Search Bar Component -->
        <div class="bg-white/95 backdrop-blur-md p-3 sm:p-4 rounded-2xl shadow-2xl max-w-4xl mx-auto border border-white/20 text-gray-800">
            <form action="{{ route('houses.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <div class="sm:col-span-4 text-left border-b sm:border-b-0 sm:border-r border-gray-200/80 pb-3 sm:pb-0 sm:pr-4 flex flex-col justify-center px-2">
                    <label class="block text-[10px] font-extrabold uppercase text-gray-400 tracking-wider mb-1">Location</label>
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <!-- <input type="text" name="location" placeholder="Kilimani, Westlands, Ruiru..." 
                            class="w-full bg-transparent text-sm font-semibold focus:outline-none text-dark placeholder-gray-400"> -->
                    </div>
                </div>

                <div class="sm:col-span-3 text-left border-b sm:border-b-0 sm:border-r border-gray-200/80 pb-3 sm:pb-0 sm:pr-4 flex flex-col justify-center px-2">
                    <label class="block text-[10px] font-extrabold uppercase text-gray-400 tracking-wider mb-1">Type</label>
                    <select name="type" class="w-full bg-transparent text-sm font-semibold focus:outline-none text-dark cursor-pointer appearance-none pr-4">
                        <option value="">All Categories</option>
                        <option value="hostel">Hostel</option> 
                        <option value="single_room">Single Room</option>
                        <option value="double_room">Double Room</option>
                        
                        <option value="bedsitter">Studio / Bedsitter</option>
                        <option value="one_bedroom">One Bedroom</option>
                        <option value="two_bedroom">Two Bedroom</option>
                       
                        <option value="three_bedroom">Three Bedroom</option>
                        <option value="own_compound">Own Compound</option>
                    </select>
                </div>

                <div class="sm:col-span-3 text-left pb-3 sm:pb-0 flex flex-col justify-center px-2">
                    <label class="block text-[10px] font-extrabold uppercase text-gray-400 tracking-wider mb-1">Max Price (KES)</label>
                    <input type="number" name="max_price" placeholder="e.g. 50,000" 
                        class="w-full bg-transparent text-sm font-semibold focus:outline-none text-dark placeholder-gray-400">
                </div>

                <div class="sm:col-span-2">
                    <button type="submit" 
                        class="w-full h-full min-h-[50px] bg-primary hover:bg-amber-600 text-white rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-primary/25 transition-all duration-300 flex items-center justify-center gap-2 group">
                        <span>Search</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto mt-16 pt-10 border-t border-white/10">
            <div class="p-2">
                <span class="block text-3xl sm:text-4xl font-extrabold text-white tracking-tight">500+</span>
                <span class="text-xs uppercase tracking-widest text-primary font-semibold mt-1 block">Scouted Properties</span>
            </div>
            <div class="p-2">
                <span class="block text-3xl sm:text-4xl font-extrabold text-white tracking-tight">100%</span>
                <span class="text-xs uppercase tracking-widest text-primary font-semibold mt-1 block">Verified Agents</span>
            </div>
            <div class="p-2">
                <span class="block text-3xl sm:text-4xl font-extrabold text-white tracking-tight">360°</span>
                <span class="text-xs uppercase tracking-widest text-primary font-semibold mt-1 block">Virtual Tours</span>
            </div>
            <div class="p-2">
                <span class="block text-3xl sm:text-4xl font-extrabold text-white tracking-tight">0</span>
                <span class="text-xs uppercase tracking-widest text-primary font-semibold mt-1 block">Viewing Scandals</span>
            </div>
        </div>
    </div>
</div>

<!-- Featured Listings Section -->
<section id="features" class="py-20 bg-bg border-t border-gray-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-xs font-bold uppercase tracking-[0.25em] text-primary mb-2 block">Fresh On Market</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-dark tracking-tight">Featured Cribs</h2>
            </div>
            <a href="{{ route('houses.index') }}" class="mt-4 md:mt-0 text-xs font-bold uppercase tracking-widest text-primary hover:text-dark transition-colors flex items-center gap-1.5 group">
                <span>View All Properties</span> 
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($houses ?? [] as $house)
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-200/70 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all duration-300 group flex flex-col justify-between">
                    <div>
                        <!-- House Image Thumbnail -->
                         
                        <div class="relative h-60 overflow-hidden bg-gray-100">
                            @php
                            $firstUnit = $house->units[0] ?? null;
                            $coverImg = ($firstUnit && !empty($firstUnit['images'])) 
                                ? asset('storage/' . $firstUnit['images'][0]) 
                                : 'https://placehold.co/600x400?text=No+Image';
                            
                            $minPrice = collect($house->units)->min('price') ?? 0;
                        @endphp
                        
                        <img src="{{ $coverImg }}" 
                             alt="{{ $house->name }}" 
                             loading="lazy" 
                             decoding="async"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20 opacity-80"></div>

                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex gap-2">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-white backdrop-blur-md shadow-sm
                                    {{ ($house->status ?? 'vacant') === 'vacant' ? 'bg-success/90' : 'bg-danger/90' }}">
                                    {{ ucfirst($house->status ?? 'Vacant') }}
                                </span>
                            </div>

                            @if(!empty($house->panorama_url))
                                <div class="absolute bottom-4 right-4 bg-dark/80 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-bold text-white uppercase tracking-wider flex items-center gap-1.5 border border-white/20 shadow-lg">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span> 
                                    <span>360° Tour</span>
                                </div>
                            @endif
                        </div>

                        <!-- Details Body -->
                        <div class="p-6">
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wider mb-2">
                                <span class="text-gray-400">{{ $house->units[0]['size'] ?? 'Apartment' }}</span>
                                <span class="text-primary font-extrabold text-sm">KES {{ number_format($house->units[0]['price'] ?? 0) }}<span class="text-[10px] text-gray-400 font-normal">/mo</span></span>
                            </div>

                            <h3 class="text-lg font-bold text-dark tracking-tight group-hover:text-primary transition-colors line-clamp-1 mb-2">
                                {{ $house->title }}
                            </h3>

                            <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium mb-2">
                                <svg class="w-3.5 h-3.5 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $house->location }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Footer / CTA -->
                    <div class="px-6 pb-6 pt-0">
                        <a href="{{ route('houses.show', $house->id ?? 1) }}" 
                           class="w-full py-3 bg-bg group-hover:bg-primary group-hover:text-white text-dark rounded-xl font-bold text-xs uppercase tracking-wider transition-all duration-300 flex items-center justify-center gap-2 border border-gray-200/80 group-hover:border-primary shadow-sm">
                            <span>Inspect House</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <!-- Empty Placeholder Cards if database has no records yet -->
                @for($i = 1; $i <= 3; $i++)
                    <div class="bg-white rounded-2xl overflow-hidden border border-gray-200/70 shadow-sm p-6 text-center space-y-4">
                        <div class="h-48 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 text-xs uppercase font-bold tracking-widest border border-dashed border-gray-200">
                            Verified Scout Photo
                        </div>
                        <h3 class="text-base font-bold text-dark">Sample Kiambu Modern Studio</h3>
                        <p class="text-xs text-primary font-bold">KES 18,000 / month</p>
                        <a href="{{ route('houses.index') }}" class="block py-3 bg-primary text-white rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-amber-600 transition">
                            View Available Homes
                        </a>
                    </div>
                @endfor
            @endforelse
        </div>
    </div>
</section>

<!-- Features / How It Works -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-bold uppercase tracking-[0.25em] text-primary mb-2 block">Smarter Scouting</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-dark tracking-tight">Why Choose {{ config('app.name', 'CribSearch') }}</h2>
            <div class="w-12 h-1 bg-primary rounded-full mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="p-8 rounded-2xl bg-bg/60 border border-gray-100 hover:border-primary/40 hover:bg-white hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
                <div class="w-14 h-14 bg-dark text-primary rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-md">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-dark mb-3">360° Virtual Inspection</h3>
                <p class="text-gray-500 text-sm leading-relaxed font-normal">
                    Walk through bedrooms, kitchens, and living rooms from your phone. Inspect every detail before paying viewing fees.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="p-8 rounded-2xl bg-bg/60 border border-gray-100 hover:border-primary/40 hover:bg-white hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
                <div class="w-14 h-14 bg-dark text-primary rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-md">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-dark mb-3">100% Verified Listings</h3>
                <p class="text-gray-500 text-sm leading-relaxed font-normal">
                    Every property is physically scouted and vetted by authorized agents to guarantee existence, accurate pricing, and water/security checks.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="p-8 rounded-2xl bg-bg/60 border border-gray-100 hover:border-primary/40 hover:bg-white hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
                <div class="w-14 h-14 bg-dark text-primary rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-md">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-dark mb-3">Instant Visit Booking</h3>
                <p class="text-gray-500 text-sm leading-relaxed font-normal">
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
                <span class="inline-block px-3 py-1 rounded-full bg-primary/20 text-primary text-xs font-bold uppercase tracking-widest border border-primary/20">
                    Interactive Feature
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Experience 360° Virtual Living</h2>
                <p class="text-gray-400 text-sm leading-relaxed font-normal">
                    Drag around to explore room interiors interactively. We integrate full panoramic virtual viewing directly into house profiles so you know exactly what you are paying for.
                </p>
                <div class="pt-2">
                    <a href="{{ route('houses.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-white font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-white hover:text-dark transition-all duration-300 shadow-lg group">
                        <span>Browse 360° Homes</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Pannellum Viewer Container -->
            <div class="lg:col-span-7">
                <div class="relative rounded-2xl overflow-hidden border border-gray-800 shadow-2xl bg-black/60">
                    <div id="panorama-preview" class="w-full h-[400px]"></div>
                    <div class="absolute bottom-4 left-4 bg-dark/80 backdrop-blur-md px-4 py-2 rounded-lg text-xs font-semibold tracking-wider text-primary border border-gray-700/80 shadow-md">
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
        <div class="bg-gradient-to-r from-dark via-gray-900 to-dark rounded-3xl p-8 sm:p-16 text-center relative overflow-hidden shadow-2xl border border-gray-800">
            <div class="relative z-10 max-w-2xl mx-auto">
                <span class="text-xs font-bold uppercase tracking-[0.25em] text-primary mb-3 block">For Landlords & Agents</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-6">
                    Have a property to list or scout?
                </h2>
                <p class="text-gray-400 text-sm mb-8 leading-relaxed font-normal">
                    Join our network of verified scouts and property managers. Get high quality leads and tenant bookings directly to your agent dashboard.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="/admin" class="w-full sm:w-auto px-8 py-4 bg-primary hover:bg-white hover:text-dark text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all duration-300 shadow-lg shadow-primary/20">
                        Access Agent Portal
                    </a>
                    <a href="/contact" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold text-xs uppercase tracking-wider border border-white/10 transition-all duration-300 backdrop-blur-sm">
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