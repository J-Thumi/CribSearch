@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen py-10 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6 border-b border-gray-100 pb-8">
            <div>
                <nav class="flex mb-4 text-xs font-bold uppercase tracking-widest text-primary">
                    <a href="{{ route('houses.index') }}" class="hover:text-dark">Properties</a>
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-500">Details</span>
                </nav>
                <h1 class="text-4xl font-extrabold text-dark tracking-tight">{{ $house->name }}</h1>
                <p class="text-gray-500 mt-2 flex items-center">
                    <span class="w-2 h-2 bg-success rounded-full mr-2"></span>
                    Verified Managed Property • <span class="ml-1 font-semibold">Scout Name: {{ $house->scout->name }}</span>
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('houses.index', ['scout' => $house->scout_id]) }}" 
                class="inline-flex items-center justify-center px-6 py-4 bg-white border border-gray-200 text-dark font-bold rounded-xl hover:bg-bg transition shadow-sm">
                    <svg class="w-5 h-5 mr-2 text-actionable" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Agent Listings ({{ $house->scout->houses_count ?? $house->scout->houses()->count() }})
                </a>
                <!-- <a href="tel:{{ $house->contact_number }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-dark transition shadow-lg shadow-primary/20">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Call Agent
                </a> -->

                <a href="tel:{{ $house->contact_number }}" 
           class="inline-flex items-center justify-center px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-dark transition shadow-lg shadow-primary/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            Call Agent
        </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="lg:col-span-2 space-y-16">
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
            
            {{-- Badge counter if there are multiple scenes --}}
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
                        @click="activeIndex = {{ $index }}; window.loadPannellumScene(scenes[{{ $index }}], 'global-panorama-viewer-{{ $loop->parent->index ?? 0 }}')"
                        :class="activeIndex === {{ $index }} ? 'border-emerald-500 ring-2 ring-emerald-100' : 'border-gray-200'"
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
            <script>
            document.addEventListener("DOMContentLoaded", function () {
    if (typeof pannellum === 'undefined') {
        console.error("Pannellum script library is missing from the layout.");
        return;
    }

    // Initialize all instantly visible default viewers
    document.querySelectorAll('.panorama-viewer').forEach(function (viewer) {
        // Only load elements that aren't hidden by x-show on page load
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

// Global scope window helper function triggered by Alpine tab switches
window.initPannellumById = function(dataId) {
    const targetElement = document.querySelector(`[data-id="${dataId}"]`);
    if (targetElement) {
        // Give time for display transition state
        setTimeout(() => { initSinglePannellum(targetElement); }, 50);
    }
}
            </script>
            <div class="lg:col-span-1">
                <div class="sticky top-28 space-y-8">
                    
                    <div class="bg-white rounded-3xl overflow-hidden shadow-2xl shadow-gray-200/50 border border-gray-100">
                        <div class="p-5 bg-dark text-white flex justify-between items-center">
                            <span class="font-bold uppercase tracking-widest text-xs">Property Location</span>
                            <span class="px-2 py-1 bg-primary text-[10px] rounded">LIVE MAP</span>
                        </div>
                        <div class="h-72 grayscale-[0.2] hover:grayscale-0 transition duration-500">
                            <iframe 
                                width="100%" height="100%" frameborder="0" scrolling="no" 
                                src="https://www.openstreetmap.org/export/embed.html?bbox={{ $house->long - 0.005 }},{{ $house->lat - 0.005 }},{{ $house->long + 0.005 }},{{ $house->lat + 0.005 }}&layer=mapnik&marker={{ $house->lat }},{{ $house->long }}">
                            </iframe>
                        </div>
                        <div class="p-5 bg-gray-50">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $house->lat }},{{ $house->long }}" 
                               target="_blank" 
                               class="text-actionable font-bold text-sm flex items-center justify-center gap-2 hover:underline">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Navigate with Google Maps
                            </a>
                        </div>
                    </div>

                    <div class="bg-primary/5 p-8 rounded-3xl border border-primary/20 relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-primary/10 rounded-full"></div>
                        
                        <h4 class="text-dark font-black text-xl mb-3">Schedule a Viewing</h4>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                            Interested in this property? Contact our verified agent directly via WhatsApp for a faster response.
                        </p>
                        
                        <div class="space-y-3">
                            <a href="https://wa.me/{{ $house->contact_number }}?text=Hi, I am interested in {{ $house->name }}" 
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
</div>

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
@endsection