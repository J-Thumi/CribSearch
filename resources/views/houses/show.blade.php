@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen py-10 font-sans" x-data="{ unlockModalOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Header & Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-6 border-b border-gray-100 pb-8">
            <div>
                <nav class="flex mb-4 text-xs font-bold uppercase tracking-widest text-primary">
                    <a href="{{ route('houses.index') }}" class="hover:text-dark">Properties</a>
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-500">Details</span>
                </nav>
                <h1 class="text-4xl font-extrabold text-dark tracking-tight">{{ $house->name }}</h1>
                <p class="text-gray-500 mt-2 flex items-center flex-wrap gap-2 text-sm">
                    <span class="inline-flex items-center">
                        <span class="w-2 h-2 bg-success rounded-full mr-2"></span>
                        Verified Managed Property
                    </span>
                    <span class="text-gray-300">•</span>
                    <span class="font-semibold text-gray-700">Scout: {{ $house->scout->name }}</span>
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <button 
                    @click="unlockModalOpen = true"
                    type="button"
                    class="inline-flex items-center justify-center px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow-lg shadow-emerald-600/20">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Unlock Details (KES 100)
                </button>

                <a href="{{ route('houses.index', ['scout' => $house->scout_id]) }}" 
                class="inline-flex items-center justify-center px-6 py-4 bg-white border border-gray-200 text-dark font-bold rounded-xl hover:bg-bg transition shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-actionable" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Agent Listings ({{ $house->scout->houses_count ?? $house->scout->houses()->count() }})
                </a>

                <a href="tel:{{ $house->contact_number }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-dark transition shadow-lg shadow-primary/20">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Call Scout
                </a>
            </div>
        </div>

        <!-- NEW: JKUAT Proximity & Location Overview Banner -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
            <div class="bg-bg border border-gray-200/80 rounded-2xl p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Nearest Campus Gate</span>
                    <p class="text-base font-extrabold text-dark mt-0.5">{{ $house->nearest_gate ?? 'Juja Main Stage' }}</p>
                </div>
            </div>

            <div class="bg-bg border border-gray-200/80 rounded-2xl p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-actionable/10 text-actionable flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Estimated Travel Time</span>
                    <p class="text-base font-extrabold text-dark mt-0.5">{{ $house->estimated_time_to_school ?? 'Not Specified' }}</p>
                </div>
            </div>

            <div class="bg-bg border border-gray-200/80 rounded-2xl p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Locality / Area</span>
                    <p class="text-base font-extrabold text-dark mt-0.5 truncate">{{ $house->approximate_area ?? $house->address }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left Main Content Column -->
            <div class="lg:col-span-2 space-y-12">
                
                @if(!empty($house->Amenities))
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm space-y-8">
                        <div class="border-b border-gray-100 pb-4">
                            <h2 class="text-xl font-bold text-gray-800 tracking-tight">Property Features</h2>
                            <p class="text-xs text-gray-400 mt-0.5">What this building offers</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Onsite Facilities
                                </h4>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    @foreach($house->Amenities as $amenityGroup)
                                        @if(!empty($amenityGroup['onsite_amenities']))
                                            @foreach($amenityGroup['onsite_amenities'] as $amenity)
                                                <li class="flex items-center gap-3 text-sm font-medium text-gray-700 bg-gray-50/70 border border-gray-100/80 rounded-xl px-3 py-2.5 hover:bg-gray-50 transition duration-200">
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

                            <div class="space-y-4">
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                    Social & Community
                                </h4>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    @foreach($house->Amenities as $amenityGroup)
                                        @if(!empty($amenityGroup['social_amenities']))
                                            @foreach($amenityGroup['social_amenities'] as $amenity)
                                                <li class="flex items-center gap-3 text-sm font-medium text-gray-700 bg-gray-50/70 border border-gray-100/80 rounded-xl px-3 py-2.5 hover:bg-gray-50 transition duration-200">
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

                @foreach($house->units as $index => $unit)
                    <section class="relative group">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 border-l-4 border-primary pl-4">
                            <h3 class="text-2xl font-bold text-dark capitalize tracking-tight">
                                {{ str_replace('_', ' ', $unit['size']) }}
                            </h3>

                            @php
                                $badgeColor = match($unit['status'] ?? 'vacant') {
                                    'vacant' => 'bg-success',
                                    'occupied' => 'bg-danger',
                                    'pending' => 'bg-warning',
                                    default => 'bg-gray-500'
                                };
                            @endphp
                            <span class="{{ $badgeColor }} text-white text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-widest shadow-sm">
                                {{ $unit['status'] ?? 'Vacant' }}
                            </span>
                            <div class="mt-2 sm:mt-0">
                                <span class="text-2xl font-black text-dark">KES {{ number_format($unit['price']) }}</span>
                                <span class="text-gray-400 text-sm font-medium">/ month</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @if(!empty($unit['images']))
                                @foreach($unit['images'] as $img)
                                    <div class="relative overflow-hidden rounded-xl h-40 md:h-52 bg-bg border border-gray-100 group/img">
                                        <a href="{{ asset('storage/'.$img) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$img) }}" 
                                                 class="w-full h-full object-cover transform group-hover/img:scale-110 transition duration-700">
                                            <div class="absolute inset-0 bg-dark/20 opacity-0 group-hover/img:opacity-100 transition duration-300 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-span-full bg-bg border-2 border-dashed border-gray-200 p-10 text-center text-gray-400 rounded-2xl">
                                    No gallery images available for this unit type.
                                </div>
                            @endif
                        </div>

                        @if(!empty($unit['virtual_tour_images']))
                            <div class="w-full my-6 bg-white border border-gray-100 rounded-xl p-4 shadow-sm" x-data="{ activeTour: 0 }">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Virtual 360° Tour
                                        </h3>
                                        <p class="text-xs text-gray-400 mt-0.5">Drag to look around the space</p>
                                    </div>
                                    
                                    @if(count($unit['virtual_tour_images']) > 1)
                                        <span class="text-xs font-medium bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">
                                            {{ count($unit['virtual_tour_images']) }} Scenes Available
                                        </span>
                                    @endif
                                </div>

                                <div class="relative overflow-hidden rounded-xl bg-gray-50 border border-gray-200">
                                    @foreach ($unit['virtual_tour_images'] as $index => $image_path)
                                        <div
                                            x-show="activeTour === {{ $index }}"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            class="panorama-viewer w-full"
                                            style="height: 480px;" 
                                            data-id="tour-{{ $loop->parent->index ?? 0 }}-{{ $index }}"
                                            data-panorama="{{ asset('storage/' . $image_path) }}">
                                        </div>
                                    @endforeach
                                </div>

                                @if(count($unit['virtual_tour_images']) > 1)
                                    <div class="flex items-center gap-3 mt-3 overflow-x-auto pb-2">
                                        @foreach ($unit['virtual_tour_images'] as $index => $image_path)
                                            <button 
                                                @click="activeTour = {{ $index }}; window.initPannellumById('tour-{{ $loop->parent->index ?? 0 }}-{{ $index }}')"
                                                :class="activeTour === {{ $index }} ? 'border-emerald-500 ring-2 ring-emerald-100' : 'border-gray-200'"
                                                class="relative flex-shrink-0 w-20 h-14 rounded-lg border-2 overflow-hidden transition-all duration-200 bg-gray-100">
                                                <img src="{{ asset('storage/' . $image_path) }}" class="w-full h-full object-cover brightness-90">
                                                <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-white bg-black/30">
                                                    Scene {{ $index + 1 }}
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
                <div class="sticky top-28 space-y-8">
                    
                    <!-- Map Box -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-2xl shadow-gray-200/50 border border-gray-100">
                        <div class="p-5 bg-dark text-white flex justify-between items-center">
                            <span class="font-bold uppercase tracking-widest text-xs">Property Location</span>
                            <span class="px-2 py-1 bg-primary text-[10px] rounded font-bold">LIVE MAP</span>
                        </div>
                        <div class="h-64 grayscale-[0.2] hover:grayscale-0 transition duration-500">
                            <iframe 
                                width="100%" height="100%" frameborder="0" scrolling="no" 
                                src="https://www.openstreetmap.org/export/embed.html?bbox={{ $house->long - 0.005 }},{{ $house->lat - 0.005 }},{{ $house->long + 0.005 }},{{ $house->lat + 0.005 }}&layer=mapnik&marker={{ $house->lat }},{{ $house->long }}">
                            </iframe>
                        </div>
                        <div class="p-5 bg-gray-50 border-t border-gray-100">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $house->lat }},{{ $house->long }}" 
                               target="_blank" 
                               class="text-actionable font-bold text-sm flex items-center justify-center gap-2 hover:underline">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Navigate with Google Maps
                            </a>
                        </div>
                    </div>

                    <!-- Caretaker Contact Card -->
                    @if(!empty($house->caretaker_phone) || !empty($house->caretaker_name))
                        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold">
                                    🔑
                                </div>
                                <div>
                                    <h4 class="text-xs font-black uppercase text-gray-400 tracking-wider">On-Site Caretaker</h4>
                                    <p class="text-base font-bold text-dark">{{ $house->caretaker_name ?? 'Building Caretaker' }}</p>
                                </div>
                            </div>
                            
                            @if(!empty($house->caretaker_phone))
                                <a href="tel:{{ $house->caretaker_phone }}" 
                                   class="w-full inline-flex justify-center items-center px-4 py-3 bg-bg text-dark font-bold text-xs uppercase tracking-widest rounded-xl border border-gray-200 hover:bg-dark hover:text-white transition">
                                    <svg class="w-4 h-4 mr-2 text-actionable" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    Call Caretaker ({{ $house->caretaker_phone }})
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- WhatsApp & Viewing CTA Card -->
                    <div class="bg-primary/5 p-8 rounded-3xl border border-primary/20 relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-primary/10 rounded-full"></div>
                        
                        <h4 class="text-dark font-black text-xl mb-3">Schedule a Viewing</h4>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                            Interested in this property? Contact our verified agent directly via WhatsApp for a faster response.
                        </p>
                        
                        <div class="space-y-3">
                            <a href="https://wa.me/{{ $house->contact_number }}?text=Hi,%20I%20am%20interested%20in%20{{ urlencode($house->name) }}" 
                               target="_blank"
                               class="w-full inline-flex justify-center items-center px-6 py-4 bg-success text-white font-bold rounded-xl hover:shadow-lg hover:shadow-success/30 transition">
                                <svg class="w-5 h-5 mr-2 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.319 1.592 5.448 0 9.886-4.438 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.735-.981z"/></svg>
                                WhatsApp Agent
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- STK Push Unlock Modal -->
    <div 
        x-show="unlockModalOpen" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true">
        
        <div 
            x-show="unlockModalOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="unlockModalOpen = false"
            class="fixed inset-0 bg-dark/60 backdrop-blur-sm transition-opacity"></div>

        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div 
                x-show="unlockModalOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border border-gray-100 p-6 sm:p-8">
                
                <button 
                    @click="unlockModalOpen = false" 
                    class="absolute top-5 right-5 text-gray-400 hover:text-dark transition p-2 rounded-full hover:bg-bg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-black text-xl shrink-0">
                        🔓
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-dark tracking-tight">Unlock Full Details</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Instant access via M-Pesa STK Push</p>
                    </div>
                </div>

                <div class="bg-bg border border-gray-200/80 rounded-2xl p-4 mb-6 flex justify-between items-center">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 block">Unlock Fee</span>
                        <span class="text-sm font-medium text-gray-600">Full Caretaker & Exact Details</span>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-black text-emerald-600">KES 100</span>
                    </div>
                </div>

                <form action="/unlock" method="POST" class="space-y-4">
                    <!-- Required CSRF token for Laravel POST requests -->
                    @csrf

                    <div>
                        <label for="phone_number" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                            M-Pesa Phone Number
                        </label>
                        <input 
                            type="text" 
                            name="phone_number" 
                            id="phone_number" 
                            placeholder="254712345678" 
                            required 
                            class="w-full px-4 py-2 border rounded-md"
                        />
                    </div>

                    <div>
                        <label for="amount" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                            M-Pesa Amount
                        </label>
                        <input 
                        class="block text-xs font-bold mb-2"
                            type="text" 
                            name="amount" 
                            id="amount" 
                            value=100
                            readonly
                            required 
                        />
                    </div>

                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md font-bold hover:bg-green-700">
                        Pay via M-Pesa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    if (typeof pannellum === 'undefined') {
        console.error("Pannellum script library is missing from the layout.");
        return;
    }

    document.querySelectorAll('.panorama-viewer').forEach(function (viewer) {
        if (viewer.style.display !== 'none') {
            initSinglePannellum(viewer);
        }
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
@endsection