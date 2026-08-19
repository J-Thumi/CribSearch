@extends('layouts.app')

@section('content')
@php
    // Check if user has unlocked house details via helper function
    $unlocked = function_exists('isHouseDetailsUnlocked') ? isHouseDetailsUnlocked() : false;
@endphp

<div class="bg-slate-50 min-h-screen py-10 font-sans" 
     x-data="{ 
        unlockModalOpen: false,
        lightboxOpen: false,
        activeImages: [],
        currentIndex: 0,

        // STK Feedback State
        stkStatus: 'idle', // 'idle' | 'loading' | 'success' | 'error'
        stkMessage: '',
        stkErrors: [],

        openLightbox(images, index) {
            this.activeImages = images;
            this.currentIndex = index;
            this.lightboxOpen = true;
        },
        nextImage() {
            if (this.activeImages.length > 0) {
                this.currentIndex = (this.currentIndex + 1) % this.activeImages.length;
            }
        },
        prevImage() {
            if (this.activeImages.length > 0) {
                this.currentIndex = (this.currentIndex - 1 + this.activeImages.length) % this.activeImages.length;
            }
        },
        resetStkState() {
            this.stkStatus = 'idle';
            this.stkMessage = '';
            this.stkErrors = [];
        },
        closeModal() {
            this.unlockModalOpen = false;
            setTimeout(() => this.resetStkState(), 300);
        },
        async submitStkPush(e) {
            const form = e.target;
            const formData = new FormData(form);
            
            this.stkStatus = 'loading';
            this.stkMessage = '';
            this.stkErrors = [];

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || formData.get('_token')
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    this.stkStatus = 'success';
                    this.stkMessage = result.message || 'STK Push sent successfully! Please check your phone and enter your M-Pesa PIN.';
                } else {
                    this.stkStatus = 'error';
                    this.stkMessage = result.message || 'Failed to initiate M-Pesa payment. Please check your phone number and try again.';
                    if (result.errors) {
                        this.stkErrors = Object.values(result.errors).flat();
                    }
                }
            } catch (err) {
                this.stkStatus = 'error';
                this.stkMessage = 'Network error occurred while connecting to the payment server. Please try again.';
            }
        }
     }"
     @keydown.escape.window="lightboxOpen = false; closeModal()"
     @keydown.arrow-right.window="if(lightboxOpen) nextImage()"
     @keydown.arrow-left.window="if(lightboxOpen) prevImage()">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Header & Actions -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-card mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 border-b border-slate-100 pb-8">
                <div>
                    <nav class="flex mb-3 text-[11px] font-bold uppercase tracking-widest text-primary">
                        <a href="{{ route('houses.index') }}" class="hover:text-dark transition-colors">Properties</a>
                        <span class="mx-2 text-slate-300">/</span>
                        <span class="text-slate-500">Details</span>
                    </nav>
                    <h1 class="text-3xl sm:text-4xl font-black text-dark tracking-tight mb-2">{{ $house->name }}</h1>
                    <p class="text-slate-500 flex items-center flex-wrap gap-2 text-xs sm:text-sm">
                        <span class="inline-flex items-center text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200/60">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span>
                            Verified Property
                        </span>
                        <span class="text-slate-300">•</span>
                        <span class="font-bold text-slate-700">
                            
                            <div class="mt-4 flex items-start gap-3 bg-amber-50/70 border border-amber-200/70 rounded-2xl p-3.5 max-w-2xl">
                                <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10a2 2 0 012-2h2"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 8V6a4 4 0 018 0v2m-4 4v4"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-amber-700">
                                        Need Help With This Property?
                                    </p>

                                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mt-1">
                                        Speak directly with
                                        <span class="font-bold text-dark">
                                            {{ $house->scout->name ?? 'our property scout' }} 
                                        </span>
                                         on 
                                        <span class="font-bold text-dark">
                                            {{ $house->contact_number ?? 'our property scout' }}
                                        </span>,
                                        the scout who uploaded this listing.
                                        They can help you
                                        <span class="font-semibold text-slate-800">
                                            book a viewing, guide you to the property, arrange a visit,
                                            confirm availability, show you the available units,
                                            answer questions about the house and neighbourhood,
                                            and help you get in touch with the caretaker.
                                        </span>
                                    </p>

                                    <p class="text-[11px] text-slate-400 mt-2">
                                        Your scout can also assist with directions, viewing schedules,
                                        house availability and other on-the-ground questions.
                                    </p>
                                </div>
                            </div>


                        </span>
                    </p>
                </div>
                
                <div class="flex flex-wrap sm:flex-nowrap gap-3">
                    @if(!$unlocked)
                        <button 
                            @click="
                                @auth
                                    unlockModalOpen = true
                                @else
                                    window.location.href = '{{ route('login', ['redirect' => url()->current()]) }}'
                                @endauth
                            "
                            type="button"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md hover:shadow-lg">
                            
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2v6a2 2 0 00-2 2z"/>
                            </svg>

                            Unlock Details (KES 250)
                        </button>
                    @else
                        <div class="inline-flex items-center justify-center px-5 py-3.5 bg-emerald-50 text-emerald-800 border border-emerald-200/80 font-bold rounded-xl text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Full Details Unlocked
                        </div>
                    @endif

                    <a href="{{ route('houses.index', ['scout' => $house->scout_id]) }}" 
                    class="inline-flex items-center justify-center px-4 py-3.5 bg-slate-100 border border-slate-200/80 text-dark font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-slate-200 transition">
                        <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Agent Listings ({{ $house->scout->houses_count ?? $house->scout->houses()->count() }})
                    </a>

                    <a href="tel:{{ $house->contact_number }}" 
                    class="inline-flex items-center justify-center px-5 py-3.5 bg-primary hover:bg-dark text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow-sm hover:shadow">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Call {{ $house->scout->name ?? 'our property scout' }}
                    </a>
                </div>
            </div>

            <!-- JKUAT Proximity & Location Overview Banner -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <!-- Public: Nearest Gate -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-primary flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Nearest Campus Gate</span>
                        <p class="text-sm font-bold text-dark mt-0.5">{{ $house->nearest_gate ?? 'Juja Main Stage' }}</p>
                    </div>
                </div>

                <!-- Gated: Estimated Travel Time -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-sky-500/10 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Estimated Travel Time</span>
                        @if($unlocked)
                            <p class="text-sm font-bold text-dark mt-0.5">{{ $house->estimated_time_to_school ?? 'Not Specified' }}</p>
                        @else
                            <p @click="unlockModalOpen = true" class="text-sm font-bold text-dark mt-0.5 blur-sm select-none cursor-pointer hover:opacity-80 transition" title="Click to unlock">
                                10 Mins Walk
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Gated: Locality / Area -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Locality / Area</span>
                        @if($unlocked)
                            <p class="text-sm font-bold text-dark mt-0.5 truncate">{{ $house->approximate_area ?? $house->address }}</p>
                        @else
                            <p @click="unlockModalOpen = true" class="text-sm font-bold text-dark mt-0.5 blur-sm select-none cursor-pointer hover:opacity-80 transition" title="Click to unlock">
                                Highpoint Juja Stage
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Main Content Column -->
            <div class="lg:col-span-2 space-y-8">

                @if(!empty($house->description))
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-card space-y-4">
                        <div class="border-b border-slate-100 pb-4">
                            <h2 class="text-lg font-bold text-dark tracking-tight">
                                About This Property
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">
                                Verified Scout Overview
                            </p>
                        </div>

                        <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2">
                            {!! nl2br(e($house->description)) !!}
                        </div>
                    </div>
                @endif
                
                @if(!empty($house->Amenities))
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-card space-y-6">
                        <div class="border-b border-slate-100 pb-4">
                            <h2 class="text-lg font-bold text-dark tracking-tight">Property Features</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Key amenities and facilities offered</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Onsite Facilities
                                </h4>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($house->Amenities as $amenityGroup)
                                        @if(!empty($amenityGroup['onsite_amenities']))
                                            @foreach($amenityGroup['onsite_amenities'] as $amenity)
                                                <li class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200/60 rounded-xl px-3 py-2">
                                                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span class="truncate capitalize">{{ str_replace('_', ' ', $amenity) }}</span>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                            <div class="space-y-3">
                                <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                    Social & Community
                                </h4>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($house->Amenities as $amenityGroup)
                                        @if(!empty($amenityGroup['social_amenities']))
                                            @foreach($amenityGroup['social_amenities'] as $amenity)
                                                <li class="flex items-center gap-2.5 text-xs font-semibold text-slate-700 bg-slate-50 border border-slate-200/60 rounded-xl px-3 py-2">
                                                    <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                    </svg>
                                                    <span class="truncate capitalize">{{ str_replace('_', ' ', $amenity) }}</span>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Unit Types Iteration -->
                @foreach($house->units as $index => $unit)
                    <section class="bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-card space-y-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-2">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-primary block mb-1">Unit Option</span>
                                <h3 class="text-xl font-black text-dark capitalize tracking-tight">
                                    {{ str_replace('_', ' ', $unit['size']) }}
                                </h3>
                            </div>

                            <div class="flex items-center gap-3">
                                @php
                                    $badgeStyle = match($unit['status'] ?? 'vacant') {
                                        'vacant' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'occupied' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        default => 'bg-slate-50 text-slate-700 border-slate-200'
                                    };
                                @endphp
                                <span class="{{ $badgeStyle }} border text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-widest">
                                    {{ $unit['status'] ?? 'Vacant' }}
                                </span>
                                
                                <div>
                                    <span class="text-xl font-black text-dark">KES {{ number_format($unit['price']) }}</span>
                                    <span class="text-slate-400 text-xs font-medium">/ mo</span>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @if(!empty($unit['images']))
                                @php
                                    $unitImages = array_map(fn($img) => asset('storage/' . $img), $unit['images']);
                                @endphp

                                @foreach($unit['images'] as $imgIndex => $img)
                                    <div class="relative overflow-hidden rounded-2xl h-40 md:h-48 bg-slate-100 border border-slate-200/60 group/img cursor-pointer"
                                         @click="openLightbox({{ json_encode($unitImages) }}, {{ $imgIndex }})">
                                        
                                        <img 
                                            src="{{ asset('storage/'.$img) }}"
                                            alt="{{ $house->name }} - {{ str_replace('_', ' ', $unit['size']) }}"
                                            loading="lazy"
                                            decoding="async"
                                            class="w-full h-full object-cover transform group-hover/img:scale-105 transition duration-500"
                                        >
                                        <div class="absolute inset-0 bg-dark/30 opacity-0 group-hover/img:opacity-100 transition duration-300 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-span-full bg-slate-50 border-2 border-dashed border-slate-200 p-8 text-center text-slate-400 rounded-2xl text-xs">
                                    No gallery images available for this unit type.
                                </div>
                            @endif
                        </div>

                        <!-- Virtual 360 Tour Viewer -->
                        @if(!empty($unit['virtual_tour_images']))
                            <div class="mt-6 bg-slate-50 border border-slate-200/80 rounded-2xl p-4 shadow-sm" x-data="{ activeTour: 0 }">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-dark flex items-center gap-2">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Virtual 360° Tour
                                        </h4>
                                        <p class="text-[11px] text-slate-400">Drag to look around the space</p>
                                    </div>
                                    
                                    @if(count($unit['virtual_tour_images']) > 1)
                                        <span class="text-[10px] font-bold bg-white text-slate-600 border border-slate-200 px-2.5 py-1 rounded-full">
                                            {{ count($unit['virtual_tour_images']) }} Scenes
                                        </span>
                                    @endif
                                </div>

                                <div class="relative overflow-hidden rounded-xl bg-slate-900 border border-slate-200">
                                    @foreach ($unit['virtual_tour_images'] as $tourIndex => $image_path)
                                        <div
                                            x-show="activeTour === {{ $tourIndex }}"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            class="panorama-viewer w-full"
                                            style="height: 420px;" 
                                            data-id="tour-{{ $loop->parent->index ?? 0 }}-{{ $tourIndex }}"
                                            data-panorama="{{ asset('storage/' . $image_path) }}">
                                        </div>
                                    @endforeach
                                </div>

                                @if(count($unit['virtual_tour_images']) > 1)
                                    <div class="flex items-center gap-2.5 mt-3 overflow-x-auto pb-1">
                                        @foreach ($unit['virtual_tour_images'] as $tourIndex => $image_path)
                                            <button 
                                                @click="activeTour = {{ $tourIndex }}; window.initPannellumById('tour-{{ $loop->parent->index ?? 0 }}-{{ $tourIndex }}')"
                                                :class="activeTour === {{ $tourIndex }} ? 'border-primary ring-2 ring-primary/20 scale-[1.02]' : 'border-slate-200 hover:border-slate-300'"
                                                class="relative flex-shrink-0 w-16 h-12 rounded-lg border-2 overflow-hidden transition-all duration-200 bg-slate-100">
                                                <img 
                                                    src="{{ asset('storage/' . $image_path) }}" 
                                                    alt="360° tour scene {{ $tourIndex + 1 }}"
                                                    loading="lazy"
                                                    decoding="async"
                                                    class="w-full h-full object-cover brightness-90"
                                                >
                                                <div class="absolute inset-0 flex items-center justify-center text-[9px] font-extrabold text-white bg-black/40">
                                                    S{{ $tourIndex + 1 }}
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    </section>
                @endforeach
            </div>

            <!-- Right Sidebar Column -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 space-y-6">
                    
                    <!-- Gated Map Box -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-card border border-slate-200/80 relative">
                        <div class="p-4 bg-dark text-white flex justify-between items-center">
                            <span class="font-bold uppercase tracking-widest text-xs">Property Location</span>
                            <span class="px-2 py-0.5 bg-primary text-[10px] rounded font-bold">LIVE MAP</span>
                        </div>

                        @if($unlocked)
                            <div class="h-60 grayscale-[0.1] hover:grayscale-0 transition duration-500">
                                <iframe 
                                    width="100%" height="100%" frameborder="0" scrolling="no" 
                                    src="https://www.openstreetmap.org/export/embed.html?bbox={{ $house->long - 0.005 }},{{ $house->lat - 0.005 }},{{ $house->long + 0.005 }},{{ $house->lat + 0.005 }}&layer=mapnik&marker={{ $house->lat }},{{ $house->long }}">
                                </iframe>
                            </div>
                            <div class="p-4 bg-slate-50 border-t border-slate-100">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $house->lat }},{{ $house->long }}" 
                                   target="_blank" 
                                   class="text-sky-600 font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Navigate with Google Maps
                                </a>
                            </div>
                        @else
                            <div class="h-60 relative bg-slate-100 flex items-center justify-center overflow-hidden">
                                <iframe 
                                    class="w-full h-full blur-md opacity-30 pointer-events-none" 
                                    src="https://www.openstreetmap.org/export/embed.html?bbox=37.00,-1.10,37.02,-1.08">
                                </iframe>
                                <div class="absolute inset-0 bg-dark/40 backdrop-blur-xs flex flex-col items-center justify-center text-center p-4">
                                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-lg text-white mb-2">
                                        🔒
                                    </div>
                                    <p class="text-xs font-bold text-white mb-3">Exact map coordinates locked</p>
                                    <button @click="unlockModalOpen = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-md">
                                        Unlock Map View
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Gated Caretaker Contact Card -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-card space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-primary flex items-center justify-center font-bold">
                                🔑
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black uppercase text-slate-400 tracking-wider">
                                    On-Site Caretakers
                                </h4>
                                <p class="text-sm font-bold text-dark">
                                    Contact Information
                                </p>
                            </div>
                        </div>

                        @if($unlocked && !empty($house->caretaker_phone) && count($house->caretaker_phone) > 0)
                            <div class="space-y-2.5">
                                @foreach($house->caretaker_phone as $contact)
                                    <div class="border border-slate-200/80 rounded-2xl p-3.5 space-y-2 bg-slate-50">
                                        <div>
                                            <p class="text-xs font-bold text-dark">
                                                {{ $contact['name'] ?? 'Building Caretaker' }}
                                            </p>
                                            <p class="text-[10px] text-slate-400">
                                                Caretaker
                                            </p>
                                        </div>

                                        @if(!empty($contact['phone']))
                                            <a href="tel:{{ $contact['phone'] }}"
                                               class="w-full inline-flex justify-center items-center px-3 py-2 bg-white text-dark font-bold text-xs uppercase tracking-wider rounded-xl border border-slate-200 hover:bg-dark hover:text-white transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 mr-1.5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                Call {{ $contact['name'] ?? 'Caretaker' }} ({{ $contact['phone'] }})
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 bg-slate-50 border border-dashed border-slate-200 rounded-2xl text-center space-y-3">
                                <div class="space-y-1">
                                    <p class="text-xs font-bold text-slate-700 blur-sm select-none">
                                        John Doe: 0712 345 678
                                    </p>
                                    <p class="text-[11px] text-slate-400">
                                        Caretaker numbers are hidden
                                    </p>
                                </div>
                                <button @click="unlockModalOpen = true" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow-md">
                                    Unlock Caretaker Number
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- WhatsApp CTA Card -->
                    <div class="bg-amber-500/5 p-6 sm:p-8 rounded-3xl border border-amber-500/20 relative overflow-hidden">
                        <div class="absolute -right-8 -bottom-8 w-28 h-28 bg-amber-500/10 rounded-full"></div>
                        <h4 class="text-dark font-black text-lg mb-2">Schedule a Viewing</h4>
                        <p class="text-slate-600 text-xs mb-6 leading-relaxed">
                            Interested in this property? Contact our verified agent directly via WhatsApp for a faster response.
                        </p>
                       @php
                            $phone = preg_replace('/\D/', '', $house->contact_number);

                            if (str_starts_with($phone, '0')) {
                                $phone = '254' . substr($phone, 1);
                            }
                        @endphp

                        <a href="https://wa.me/{{ $phone }}?text={{ urlencode('Hi, I am interested in ' . $house->name) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-full inline-flex justify-center items-center px-5 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl hover:shadow-lg transition">

                            <svg class="w-4 h-4 mr-2 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001 3.951-.5 5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.319 1.592 5.448 0 9.886-4.438 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.735-.981z"/>
                            </svg>

                            WhatsApp Agent
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Image Lightbox Modal -->
    <div x-show="lightboxOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-8"
         role="dialog" 
         aria-modal="true">
        
        <div x-show="lightboxOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="lightboxOpen = false"
             class="fixed inset-0 bg-dark/90 backdrop-blur-md"></div>

        <div x-show="lightboxOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative z-10 w-full max-w-5xl flex flex-col items-center">

            <button @click="lightboxOpen = false" 
                    class="absolute -top-12 right-0 text-white/80 hover:text-white transition p-2 rounded-full hover:bg-white/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="relative w-full flex items-center justify-center min-h-[300px] max-h-[80vh] overflow-hidden rounded-2xl bg-black/40">
                <template x-if="activeImages.length > 0">
                    <img :src="activeImages[currentIndex]" 
                         alt="Property Image" 
                         class="max-w-full max-h-[80vh] object-contain rounded-xl select-none shadow-2xl">
                </template>

                <button @click="prevImage()" 
                        x-show="activeImages.length > 1"
                        class="absolute left-3 p-3 rounded-full bg-dark/60 text-white/90 hover:text-white hover:bg-dark/90 transition border border-white/10 backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <button @click="nextImage()" 
                        x-show="activeImages.length > 1"
                        class="absolute right-3 p-3 rounded-full bg-dark/60 text-white/90 hover:text-white hover:bg-dark/90 transition border border-white/10 backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <div x-show="activeImages.length > 1" class="mt-4 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-white text-xs font-bold tracking-wider">
                <span x-text="currentIndex + 1"></span> / <span x-text="activeImages.length"></span>
            </div>
        </div>
    </div>

    <!-- STK Push / Unlock Details Modal -->
    <div 
        x-show="unlockModalOpen" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        role="dialog" 
        aria-modal="true">
        
        <!-- Backdrop -->
        <div 
            x-show="unlockModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="closeModal()"
            class="fixed inset-0 bg-dark/60 backdrop-blur-xs transition-opacity"></div>

        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div 
                x-show="unlockModalOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border border-slate-100 p-6 sm:p-8">
                
                <!-- Close Button -->
                <button 
                    @click="closeModal()" 
                    class="absolute top-5 right-5 text-slate-400 hover:text-dark transition p-2 rounded-full hover:bg-slate-100 z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- 1. IDLE STATE: STK Push Form -->
                <template x-if="stkStatus === 'idle' || stkStatus === 'loading'">
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-black text-xl shrink-0">
                                🔓
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-dark tracking-tight leading-snug">
                                    Unlock Property Contacts & Map
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    Direct caretaker details and map location will be delivered to your phone.
                                </p>
                            </div>
                        </div>

                        <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 mb-6 flex justify-between items-center">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block">Unlock Fee</span>
                                <span class="text-xs font-medium text-slate-600">The house details will be sent to your number via sms</span>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-black text-emerald-600">KES 250</span>
                            </div>
                        </div>

                        <form @submit.prevent="submitStkPush($event)" action="{{ route('unlock', $house) }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="house_id" value="{{ $house->id }}">

                            <div>
                                <label for="phone_number" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    M-Pesa Payment Number
                                </label>
                                <input 
                                    type="tel" 
                                    name="phone_number" 
                                    id="phone_number" 
                                    placeholder="e.g. 254712345678" 
                                    required 
                                    :disabled="stkStatus === 'loading'"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-xs font-medium transition disabled:opacity-60"
                                />
                                <span class="text-[10px] text-slate-400 mt-1 block">An STK prompt will pop up on this phone line.</span>
                            </div>

                            <div>
                                <label for="text_phone_number" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    SMS Recipient Number
                                </label>
                                <input 
                                    type="tel" 
                                    name="text_phone_number" 
                                    id="text_phone_number" 
                                    placeholder="e.g. 254712345678" 
                                    required 
                                    :disabled="stkStatus === 'loading'"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none text-xs font-medium transition disabled:opacity-60"
                                />
                            </div>

                            <button 
                                type="submit" 
                                :disabled="stkStatus === 'loading'"
                                class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2 disabled:opacity-75">
                                
                                <template x-if="stkStatus === 'loading'">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                
                                <span x-text="stkStatus === 'loading' ? 'Sending STK Push...' : 'Pay KES 250 via M-Pesa'"></span>
                            </button>
                        </form>
                    </div>
                </template>

                <!-- 2. SUCCESS POPUP STATE -->
                <template x-if="stkStatus === 'success'">
                    <div class="text-center py-4 space-y-4">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-full inline-flex items-center justify-center text-3xl shadow-sm animate-bounce">
                            📱
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-black text-dark tracking-tight">STK Push Initiated!</h3>
                            <p class="text-xs text-slate-600 mt-2 leading-relaxed max-w-sm mx-auto" x-text="stkMessage"></p>
                        </div>

                        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-left text-xs text-emerald-800 space-y-1.5">
                            <p class="font-bold flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Next Steps:
                            </p>
                            <ol class="list-decimal list-inside space-y-1 text-[11px] text-emerald-700">
                                <li>Check your phone display for the M-Pesa prompt.</li>
                                <li>Enter your M-Pesa PIN to authorize payment.</li>
                                <li>Details will be unlocked & texted automatically.</li>
                            </ol>
                        </div>

                        <div class="pt-2">
                            <button 
                                @click="closeModal()" 
                                class="w-full py-3 bg-slate-900 hover:bg-black text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow">
                                Got It
                            </button>
                        </div>
                    </div>
                </template>

                <!-- 3. ERROR POPUP STATE -->
                <template x-if="stkStatus === 'error'">
                    <div class="text-center py-4 space-y-4">
                        <div class="w-16 h-16 bg-rose-50 text-rose-600 rounded-full inline-flex items-center justify-center text-3xl shadow-sm">
                            ⚠️
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-black text-dark tracking-tight">STK Request Failed</h3>
                            <p class="text-xs text-rose-600 font-medium mt-2 leading-relaxed max-w-sm mx-auto" x-text="stkMessage"></p>
                        </div>

                        <template x-if="stkErrors.length > 0">
                            <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 text-left">
                                <ul class="list-disc list-inside text-xs text-rose-700 space-y-1">
                                    <template x-for="(err, idx) in stkErrors" :key="idx">
                                        <li x-text="err"></li>
                                    </template>
                                </ul>
                            </div>
                        </template>

                        <div class="pt-2 flex gap-3">
                            <button 
                                @click="resetStkState()" 
                                class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow">
                                Try Again
                            </button>
                            <button 
                                @click="closeModal()" 
                                class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider rounded-xl transition">
                                Close
                            </button>
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    if (typeof pannellum === 'undefined') {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                initSinglePannellum(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, {
        rootMargin: '300px'
    });

    document.querySelectorAll('.panorama-viewer').forEach(function (viewer) {
        observer.observe(viewer);
    });
});

function initSinglePannellum(element) {
    if (element && element.dataset.panorama && !element.classList.contains('pnlm-container')) {
        pannellum.viewer(element, {
            type: 'equirectangular',
            panorama: element.dataset.panorama,
            autoLoad: true,
            compass: false,
            uiText: { loadErrorText: "Failed to load 360° panorama." }
        });
    }
}

window.initPannellumById = function(dataId) {
    const targetElement = document.querySelector(`[data-id="${dataId}"]`);
    if (targetElement) {
        setTimeout(() => { initSinglePannellum(targetElement); }, 50);
    }
}
</script>
@endsection