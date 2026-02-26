@extends('layouts.app')

@section('content')
<div class="bg-bg min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-dark tracking-tight uppercase">Available Properties</h1>
            <p class="mt-4 text-lg text-gray-600 font-sans">Discover premium scouted listings tailored for you.</p>
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