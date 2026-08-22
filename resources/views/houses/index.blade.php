@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    @if (auth()->check() && !auth()->user()->hasVerifiedEmail())
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="font-bold text-amber-900">
                        Please verify your email address
                    </h2>

                    <p class="text-sm text-amber-800 mt-1">
                        @if (session('verification_email'))
                            If you have just registered, we sent a verification link to <strong>{{ session('verification_email') }}</strong>. Please check your inbox and spam folder to activate your account.
                        @else
                            Please verify your email address (<strong>{{ auth()->user()->email }}</strong>) to access all features.
                        @endif
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <p class="text-xs font-semibold text-emerald-700 mt-2">
                            A fresh verification link has been sent to your email address! Please check your spam folder if you don't see it.
                        </p>
                    @endif
                </div>
            </div>

            <div class="flex-shrink-0 sm:self-center">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center text-xs font-semibold uppercase tracking-wider bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-xl transition duration-150 ease-in-out">
                        Resend Verification Email
                    </button>
                </form>
            </div>

        </div>
    </div>
@endif
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
        <!-- Page Title & Header Banner -->
        <div class="mb-8 bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-card">
            <div class="max-w-3xl">
                <span class="inline-block px-3 py-1 bg-amber-500/10 text-primary font-bold text-[11px] uppercase tracking-widest rounded-full border border-amber-500/20 mb-3">
                    Scouted Listings
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-dark tracking-tight mb-3">
                    Available Properties
                </h1>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Discover premium scouted properties tailored for you with verified pricing and zero hidden viewing fees.
                </p>
            </div>

            <!-- Search & Gate Filter Form -->
            <form action="{{ route('houses.index') }}" method="GET" class="mt-8 pt-8 border-t border-slate-100">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <label for="search-input" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Search Keyword</label>
                        <div class="relative">
                            <input type="text" id="search-input" name="search" value="{{ request('search') }}" placeholder="Property name or keyword..." 
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-dark focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Campus Gate Dropdown -->
                    <div>
                        <label for="gate-select" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Campus Gate</label>
                        <select id="gate-select" name="gate" onchange="this.form.submit()" 
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-dark focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                            <option value="">All Gates / Locations</option>
                            @foreach($gates as $gate)
                                <option value="{{ $gate }}" {{ request('gate') == $gate ? 'selected' : '' }}>
                                    📍 {{ $gate }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit & Reset Buttons -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 py-2.5 bg-dark hover:bg-primary text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-sm hover:shadow transition-all duration-200">
                            Apply Filter
                        </button>
                        @if(request()->hasAny(['search', 'gate', 'size']))
                            <a href="{{ route('houses.index') }}" class="px-3.5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs uppercase tracking-wider rounded-xl transition-colors">
                                Reset
                            </a>
                        @endif
                    </div>

                </div>
            </form>
        </div>

        <!-- Visual Filter Cards: Unit Type -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">
                    Filter by Unit Type
                </h3>
                
                @if(request('size'))
                    <a href="{{ route('houses.index') }}" class="text-xs font-bold text-red-600 hover:text-red-800 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Clear Unit Filter
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    // Standardized compressed parameters for faster Unsplash delivery
                    $imgParams = '&auto=format,compress&cs=tinysrgb&w=450&q=70';
                    $unitTypes = [
                        'single_room' => ['label' => 'Single Room', 'image' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?' . $imgParams],
                        'hostel'      => ['label' => 'Hostel',      'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?' . $imgParams],
                        'bedsitter'   => ['label' => 'Bedsitter',   'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?' . $imgParams],
                        'double_room' => ['label' => 'Double Room', 'image' => 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?' . $imgParams],
                        'one_bedroom' => ['label' => '1 Bedroom',   'image' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?' . $imgParams],
                        'two_bedroom' => ['label' => '2 Bedroom',   'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?' . $imgParams],
                        'three_bedroom' => ['label' => '3 Bedroom', 'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?' . $imgParams],
                        'own_compound' => ['label' => 'Own Compound','image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?' . $imgParams],
                    ];
                @endphp

                @foreach($unitTypes as $key => $data)
                    @php
                        $isActive = request('size') === $key;
                        $queryParams = array_merge(request()->except('page'), ['size' => $key]);
                        $url = $isActive ? route('houses.index', request()->except(['size', 'page'])) : route('houses.index', $queryParams);
                    @endphp

                    <a href="{{ $url }}" 
                       class="group relative h-36 sm:h-44 rounded-2xl overflow-hidden border-2 transition-all duration-300 transform active:scale-95 shadow-sm hover:shadow-xl
                            {{ $isActive ? 'border-primary ring-4 ring-primary/20 scale-[1.02]' : 'border-transparent hover:border-white/40' }}">
                        
                        <img src="{{ $data['image'] }}" 
                             alt="{{ $data['label'] }}" 
                             fetchpriority="high"
                             loading="eager"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent transition-opacity duration-300 {{ $isActive ? 'opacity-90' : 'opacity-70 group-hover:opacity-80' }}"></div>

                        @if($isActive)
                            <div class="absolute top-3 right-3 bg-primary text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full shadow-md flex items-center gap-1 z-10">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                Selected
                            </div>
                        @endif

                        <div class="absolute bottom-0 inset-x-0 p-4 text-white z-10 flex flex-col justify-end">
                            <span class="text-base sm:text-lg font-bold leading-tight drop-shadow-md group-hover:translate-x-1 transition-transform duration-200">
                                {{ $data['label'] }}
                            </span>
                            
                            <span class="text-[11px] font-medium text-slate-200 mt-1 opacity-90">
                                {{ $isActive ? 'Click to clear filter' : 'Filter units' }} →
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- House Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($houses as $house)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-card hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group">
                    
                    <!-- Cover Image & Price Badge Container -->
                  <div class="relative h-72 overflow-hidden bg-gray-100"
                        x-data="{
                            images: {{ json_encode(collect($house->units)->flatMap(fn($u) => $u['images'] ?? [])->map(fn($img) => asset('storage/'.$img))->values()) }},
                            currentIndex: 0,
                            timer: null,
                            startAutoplay() {
                                if (this.images.length > 1) {
                                    this.timer = setInterval(() => {
                                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                                    }, 3000); // Change image every 3 seconds
                                }
                            },
                            stopAutoplay() {
                                if (this.timer) clearInterval(this.timer);
                            }
                        }"
                        x-init="startAutoplay()"
                        @mouseenter="stopAutoplay()"
                        @mouseleave="startAutoplay()">

                        @php
                            $firstUnit = $house->units[0] ?? null;
                            $minPrice = collect($house->units)->min('price') ?? 0;
                        @endphp

                        <template x-if="images.length > 0">
                            <div class="relative w-full h-full">
                                <template x-for="(image, index) in images" :key="index">
                                    <img 
                                        :src="image" 
                                        alt="{{ $house->name }}" 
                                        loading="lazy"
                                        decoding="async"
                                        class="absolute inset-0 w-full h-full object-cover object-center transition-opacity duration-1000 ease-in-out"
                                        :class="currentIndex === index ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                                    />
                                </template>
                            </div>
                        </template>

                        <template x-if="images.length === 0">
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span>No Image Available</span>
                            </div>
                        </template>

                        <!-- Optional slide indicators (dots) -->
                        <template x-if="images.length > 1">
                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex gap-1.5">
                                <template x-for="(img, i) in images" :key="i">
                                    <button
                                        @click="currentIndex = i"
                                        type="button"
                                        :aria-label="'Go to image ' + (i + 1)"
                                        class="h-1.5 rounded-full transition-all duration-300"
                                        :class="currentIndex === i ? 'bg-white w-4' : 'bg-white/50 w-1.5'">
                                    </button>
                                </template>
                            </div>
                        </template>
                        <!-- Price Tag Overlay -->
                        <div class="absolute bottom-3 left-3 bg-dark/90 backdrop-blur-md text-white px-3.5 py-1.5 rounded-xl font-black text-xs border border-white/10 shadow-lg">
                            <span class="text-primary">KES {{ number_format($minPrice) }}</span><span class="text-[10px] font-medium text-slate-300"> / mo</span>
                        </div>

                        @if($minPrice > 50000)
                            <div class="absolute top-3 right-3">
                                <span class="bg-premium text-white text-[10px] font-black px-2.5 py-1 rounded-md uppercase tracking-widest shadow-md">
                                    Premium
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Details Card Body -->
                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                            <h2 class="text-base font-bold text-dark group-hover:text-primary transition-colors line-clamp-1 mb-2 tracking-tight">
                                {{ $house->name }}
                            </h2>
                            
                            <div class="flex items-center text-slate-500 text-xs mb-4">
                                <svg class="w-4 h-4 mr-1.5 text-accent flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-bold text-dark mr-1">{{ count($house->units) }} Unit Types:</span>
                                <span class="truncate font-medium">
                                    @php
                                        $sizes = collect($house->units)
                                            ->pluck('size')
                                            ->unique()
                                            ->map(fn($size) => ucfirst(str_replace('_', ' ', $size)))
                                            ->implode(', ');
                                    @endphp
                                    
                                    {{ $sizes ?: 'No units listed' }}
                                </span>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="tel:{{ $house->contact_number }}" class="p-2 bg-slate-100 hover:bg-actionable/10 text-slate-500 hover:text-actionable rounded-xl transition-colors" title="Call Scout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </a>
                            
                            <a href="{{ route('houses.show', $house->id) }}" class="px-4 py-2 bg-slate-100 hover:bg-dark hover:text-white text-dark rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200">
                                View Details
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-slate-200/80 shadow-card">
                    <div class="w-16 h-16 bg-amber-500/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-dark mb-1">No Properties Found</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto mb-6">
                        No properties match your active search filters or gate selections. Try resetting your search parameters.
                    </p>
                    <a href="{{ route('houses.index') }}" class="inline-block px-5 py-2.5 bg-primary text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-dark transition-colors shadow-sm">
                        Reset Filters
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(method_exists($houses, 'hasPages') && $houses->hasPages())
            <div class="mt-10">
                {{ $houses->links() }}
            </div>
        @endif

    </div>
</div>
@endsection