@extends('layouts.app')

@section('content')
<div class="bg-bg min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-dark tracking-tight uppercase">Available Properties</h1>
            <p class="mt-4 text-lg text-gray-600 font-sans">Discover premium scouted listings tailored for you.</p>
        </div>

        <form action="{{ route('houses.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Existing Search Input -->
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Property name..." 
                    class="w-full bg-bg border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary">
            </div>

            <!-- NEW: Gate Filter Dropdown -->
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Campus Gate</label>
                <select name="gate" onchange="this.form.submit()" 
                        class="w-full bg-bg border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold text-dark focus:outline-none focus:border-primary">
                    <option value="">All Gates / Locations</option>
                    @foreach(['Gate A', 'Gate B', 'Gate C', 'Juja Stage', 'Gate D', 'Kiongo Gate' ,'Gachororo'] as $gate)
                        <option value="{{ $gate }}" {{ request('gate') == $gate ? 'selected' : '' }}>
                            📍 {{ $gate }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-primary text-white font-bold py-3 px-6 rounded-xl hover:bg-dark transition text-sm">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'gate']))
                    <a href="{{ route('houses.index') }}" class="bg-gray-100 text-gray-600 font-bold py-3 px-4 rounded-xl hover:bg-gray-200 transition text-sm">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Filter Cards Container -->
        <!-- Visual Filter Cards -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-dark">
                    Filter by Unit Type
                </h3>
                
                @if(request('size'))
                    <a href="{{ route('houses.index') }}" class="text-xs font-bold text-red-600 hover:text-red-800 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset Filter
                    </a>
                @endif
            </div>

            <!-- Responsive Grid with Larger Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $unitTypes = [
                        'single_room' => [
                            'label' => 'Single Room',
                            'image' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=600&q=80'
                        ],
                        'hostel' => [
                            'label' => 'Hostel',
                            'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=600&q=80'
                        ],
                        'bedsitter' => [
                            'label' => 'Bedsitter',
                            'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=600&q=80'
                        ],
                        'double_room' => [
                            'label' => 'Double Room',
                            'image' => 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=600&q=80'
                        ],
                        'one_bedroom' => [
                            'label' => '1 Bedroom',
                            'image' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=600&q=80'
                        ],
                        'two_bedroom' => [
                            'label' => '2 Bedroom',
                            'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=80'
                        ],
                        'three_bedroom' => [
                            'label' => '3 Bedroom',
                            'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80'
                        ],
                        'own_compound' => [
                            'label' => 'Own Compound',
                            'image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=600&q=80'
                        ],
                    ];
                @endphp

                @foreach($unitTypes as $key => $data)
                    @php
                        $isActive = request('size') === $key;
                        // Preserve existing query params except page when toggling
                        $queryParams = array_merge(request()->except('page'), ['size' => $key]);
                        $url = $isActive ? route('houses.index', request()->except(['size', 'page'])) : route('houses.index', $queryParams);
                    @endphp

                    <a href="{{ $url }}" 
                    class="group relative h-36 sm:h-44 rounded-2xl overflow-hidden border-2 transition-all duration-300 transform active:scale-95 shadow-sm hover:shadow-xl
                            {{ $isActive 
                                ? 'border-primary ring-4 ring-primary/20 scale-[1.02]' 
                                : 'border-transparent hover:border-white/40' 
                            }}">
                        
                        <!-- Background Image with Zoom Effect -->
                        <img src="{{ $data['image'] }}" 
                            alt="{{ $data['label'] }}" 
                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />

                        <!-- Gradient Overlay for Contrast -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent transition-opacity duration-300 {{ $isActive ? 'opacity-90' : 'opacity-70 group-hover:opacity-80' }}"></div>

                        <!-- Active Status Badge (Top-Right) -->
                        @if($isActive)
                            <div class="absolute top-3 right-3 bg-primary text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full shadow-md flex items-center gap-1 z-10">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                Selected
                            </div>
                        @endif

                        <!-- Content Overlay (Bottom-Left) -->
                        <div class="absolute bottom-0 inset-x-0 p-4 text-white z-10 flex flex-col justify-end">
                            <span class="text-base sm:text-lg font-bold leading-tight drop-shadow-md group-hover:translate-x-1 transition-transform duration-200">
                                {{ $data['label'] }}
                            </span>
                            
                            <span class="text-[11px] font-medium text-gray-200 mt-1 opacity-90">
                                {{ $isActive ? 'Click to clear filter' : 'Filter units' }} →
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($houses as $house)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:border-primary transition-all duration-300 group">
                    
                    <div class="relative h-64 overflow-hidden">
                        @php
                            $firstUnit = $house->units[0] ?? null;
                            $coverImg = ($firstUnit && !empty($firstUnit['images'])) 
                                ? asset('storage/' . $firstUnit['images'][0]) 
                                : 'https://placehold.co/600x400?text=No+Image';
                            
                            $minPrice = collect($house->units)->min('price') ?? 0;
                        @endphp
                        
                        <img src="{{ $coverImg }}" alt="{{ $house->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-dark/80 backdrop-blur px-4 py-1.5 rounded-lg text-sm font-bold text-primary shadow-lg border border-primary/30">
                                KES {{ number_format($minPrice) }}
                            </span>
                        </div>

                        @if($minPrice > 50000)
                        <div class="absolute top-4 right-4">
                            <span class="bg-premium text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-widest">
                                Premium
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <h2 class="text-xl font-bold text-dark mb-2 tracking-tight">{{ $house->name }}</h2>
                        
                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <svg class="w-4 h-4 mr-2 text-accent" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">{{ count($house->units) }} Unit Types Available</span>
                            <span class="font-medium leading-tight">
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

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="tel:{{ $house->contact_number }}" class="text-gray-400 hover:text-actionable transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </a>
                            
                            <a href="{{ route('houses.show', $house->id) }}" class="inline-flex items-center px-6 py-2 bg-primary border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-dark transition ease-in-out duration-200 shadow-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500 font-sans">No properties match your search right now.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $houses->links() }}
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