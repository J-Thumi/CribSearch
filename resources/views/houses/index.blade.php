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
        <!-- Filter Bar -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-10">
            <form action="{{ route('houses.index') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
                
                <div class="w-full sm:w-auto flex-1">
                    <label for="size" class="block text-xs font-bold uppercase tracking-wider text-dark mb-2">
                        Filter by Unit Type
                    </label>
                    <select name="size" id="size" onchange="this.form.submit()" class="w-full bg-bg border border-gray-200 text-dark text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-primary font-medium">
                        <option value="">All Unit Types</option>
                        <option value="single_room" {{ request('size') == 'single_room' ? 'selected' : '' }}>Single Room</option>
                        <option value="hostel" {{ request('size') == 'hostel' ? 'selected' : '' }}>Hostel</option>
                        <option value="double_room" {{ request('size') == 'double_room' ? 'selected' : '' }}>Double Room</option>
                        <option value="one_bedroom" {{ request('size') == 'one_bedroom' ? 'selected' : '' }}>1 Bedroom</option>
                        <option value="two_bedroom" {{ request('size') == 'two_bedroom' ? 'selected' : '' }}>2 Bedroom</option>
                        <option value="three_bedroom" {{ request('size') == 'three_bedroom' ? 'selected' : '' }}>3 Bedroom</option>
                        <option value="single_room" {{ request('size') == 'single_room' ? 'selected' : '' }}>Single Room</option>
                        <option value="own_compound" {{ request('size') == 'own_compound' ? 'selected' : '' }}>Own Compound</option>
                    </select>
                </div>

                @if(request('size'))
                    <div class="w-full sm:w-auto flex items-end pt-2 sm:pt-6">
                        <a href="{{ route('houses.index') }}" class="w-full sm:w-auto px-4 py-3 text-xs font-bold uppercase tracking-widest text-red-600 bg-red-50 border border-red-200 rounded-xl hover:bg-red-600 hover:text-white transition-all text-center">
                            Reset Filter
                        </a>
                    </div>
                @endif

            </form>
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