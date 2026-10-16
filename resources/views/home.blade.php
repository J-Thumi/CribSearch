@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Page heading --}}
        <div class="mb-5">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                Available Houses
            </h1>

            @if(method_exists($houses, 'total'))
                <p class="mt-1 text-sm text-slate-500">
                    {{ number_format($houses->total()) }} {{ $houses->total() === 1 ? 'house' : 'houses' }} available
                </p>
            @endif
        </div>


        {{-- Filters --}}
        <div class="bg-white border border-slate-200 rounded-xl mb-6">

            <form
                action="{{ route('home') }}"
                method="GET"
                class="p-4"
            >

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">

                    {{-- Search --}}
                    <div class="lg:col-span-5">
                        <label
                            for="search"
                            class="sr-only"
                        >
                            Search houses
                        </label>

                        <div class="relative">
                            <svg
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                                />
                            </svg>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search houses..."
                                class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                            >
                        </div>
                    </div>


                    {{-- Gate --}}
                    <div class="lg:col-span-3">
                        <label
                            for="gate"
                            class="sr-only"
                        >
                            Campus gate
                        </label>

                        <select
                            id="gate"
                            name="gate"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                        >
                            <option value="">All Gates / Locations</option>

                            @foreach($gates as $gate)
                                <option
                                    value="{{ $gate }}"
                                    {{ request('gate') === $gate ? 'selected' : '' }}
                                >
                                    {{ $gate }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- Unit type --}}
                    <div class="lg:col-span-3">
                        <label
                            for="size"
                            class="sr-only"
                        >
                            Unit type
                        </label>

                        <select
                            id="size"
                            name="size"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm font-medium text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                        >
                            <option value="">All Unit Types</option>

                            <option
                                value="single_room"
                                {{ request('size') === 'single_room' ? 'selected' : '' }}
                            >
                                Single Room
                            </option>

                            <option
                                value="hostel"
                                {{ request('size') === 'hostel' ? 'selected' : '' }}
                            >
                                Hostel
                            </option>

                            <option
                                value="bedsitter"
                                {{ request('size') === 'bedsitter' ? 'selected' : '' }}
                            >
                                Bedsitter
                            </option>

                            <option
                                value="double_room"
                                {{ request('size') === 'double_room' ? 'selected' : '' }}
                            >
                                Double Room
                            </option>

                            <option
                                value="one_bedroom"
                                {{ request('size') === 'one_bedroom' ? 'selected' : '' }}
                            >
                                1 Bedroom
                            </option>

                            <option
                                value="two_bedroom"
                                {{ request('size') === 'two_bedroom' ? 'selected' : '' }}
                            >
                                2 Bedroom
                            </option>

                            <option
                                value="three_bedroom"
                                {{ request('size') === 'three_bedroom' ? 'selected' : '' }}
                            >
                                3 Bedroom
                            </option>

                            <option
                                value="own_compound"
                                {{ request('size') === 'own_compound' ? 'selected' : '' }}
                            >
                                Own Compound
                            </option>
                        </select>
                    </div>


                    {{-- Search button --}}
                    <div class="lg:col-span-1">
                        <button
                            type="submit"
                            class="w-full h-full min-h-[42px] px-4 bg-primary hover:bg-dark text-white rounded-lg text-sm font-semibold transition-colors"
                        >
                            Search
                        </button>
                    </div>

                </div>


                {{-- Active filters --}}
                @if(request()->hasAny(['search', 'gate', 'size']))

                    <div class="flex flex-wrap items-center gap-2 mt-3 pt-3 border-t border-slate-100">

                        <span class="text-xs text-slate-400">
                            Filters:
                        </span>

                        @if(request('search'))
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 rounded-full text-xs font-medium text-slate-700">
                                Search: {{ request('search') }}
                            </span>
                        @endif

                        @if(request('gate'))
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 rounded-full text-xs font-medium text-slate-700">
                                {{ request('gate') }}
                            </span>
                        @endif

                        @if(request('size'))
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 rounded-full text-xs font-medium text-slate-700">
                                {{ ucfirst(str_replace('_', ' ', request('size'))) }}
                            </span>
                        @endif

                        <a
                            href="{{ route('houses.index') }}"
                            class="text-xs font-semibold text-red-600 hover:text-red-700 ml-1"
                        >
                            Clear
                        </a>

                    </div>

                @endif

            </form>
        </div>


        {{-- Unit type quick filters --}}
        <div class="flex gap-2 overflow-x-auto pb-2 mb-5 scrollbar-hide">

            @php
                $quickFilters = [
                    'single_room' => 'Single Room',
                    'hostel' => 'Hostel',
                    'bedsitter' => 'Bedsitter',
                    'double_room' => 'Double Room',
                    'one_bedroom' => '1 Bedroom',
                    'two_bedroom' => '2 Bedroom',
                    'three_bedroom' => '3 Bedroom',
                    'own_compound' => 'Own Compound',
                ];
            @endphp

            <a
                href="{{ route('houses.index', request()->except(['size', 'page'])) }}"
                class="shrink-0 px-3.5 py-2 rounded-lg border text-xs font-semibold transition-colors
                    {{ !request('size')
                        ? 'bg-dark text-white border-dark'
                        : 'bg-white text-slate-600 border-slate-200 hover:border-slate-400' }}"
            >
                All
            </a>

            @foreach($quickFilters as $key => $label)

                @php
                    $params = request()->except('page');

                    if (request('size') === $key) {
                        unset($params['size']);
                    } else {
                        $params['size'] = $key;
                    }

                    $url = route('houses.index', $params);
                @endphp

                <a
                    href="{{ $url }}"
                    class="shrink-0 px-3.5 py-2 rounded-lg border text-xs font-semibold transition-colors
                        {{ request('size') === $key
                            ? 'bg-primary text-white border-primary'
                            : 'bg-white text-slate-600 border-slate-200 hover:border-slate-400' }}"
                >
                    {{ $label }}
                </a>

            @endforeach

        </div>


        {{-- Listings heading --}}
        <div class="flex items-center justify-between mb-4">

            <div>
                <h2 class="text-base font-bold text-slate-900">
                    Houses
                </h2>

                @if(request()->hasAny(['search', 'gate', 'size']))
                    <p class="text-xs text-slate-500 mt-0.5">
                        Showing filtered results
                    </p>
                @endif
            </div>

        </div>


        {{-- House listings --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @forelse($houses as $house)

                @php
                    $images = collect($house->units)
                        ->flatMap(fn ($unit) => $unit['images'] ?? [])
                        ->map(fn ($image) => asset('storage/' . $image))
                        ->values();

                    $minPrice = collect($house->units)->min('price') ?? 0;

                    $sizes = collect($house->units)
                        ->pluck('size')
                        ->unique()
                        ->map(fn ($size) => ucfirst(str_replace('_', ' ', $size)))
                        ->implode(', ');
                @endphp


                <article
                    class="bg-white border border-slate-200 rounded-xl overflow-hidden hover:border-slate-300 hover:shadow-md transition-shadow group"
                >

                    {{-- Image --}}
                    <a
                        href="{{ route('houses.show', $house->id) }}"
                        class="block relative h-56 bg-slate-100 overflow-hidden"
                    >

                        @if($images->isNotEmpty())

                            <img
                                src="{{ $images->first() }}"
                                alt="{{ $house->name }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-300"
                            >

                        @else

                            <div class="w-full h-full flex items-center justify-center text-slate-400">
                                <svg
                                    class="w-10 h-10"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="m3 16 5-5a2 2 0 0 1 3 0l2 2 2-2a2 2 0 0 1 3 0l3 3M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"
                                    />
                                </svg>
                            </div>

                        @endif


                        {{-- Price --}}
                        <div class="absolute bottom-3 left-3">

                            <span class="inline-flex items-center px-3 py-1.5 bg-white rounded-lg shadow-sm text-sm font-bold text-slate-900">
                                KES {{ number_format($minPrice) }}
                                <span class="text-[10px] font-normal text-slate-500 ml-1">
                                    / month
                                </span>
                            </span>

                        </div>

                    </a>


                    {{-- Details --}}
                    <div class="p-4">

                        <a
                            href="{{ route('houses.show', $house->id) }}"
                            class="block"
                        >

                            <h3 class="font-semibold text-slate-900 truncate group-hover:text-primary transition-colors">
                                {{ $house->name }}
                            </h3>

                            <div class="flex items-center gap-1.5 mt-1.5 text-xs text-slate-500">

                                <svg
                                    class="w-3.5 h-3.5 shrink-0"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>

                                <span class="truncate">
                                    {{ $house->nearest_gate ?? 'Juja' }}
                                </span>

                            </div>

                        </a>


                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100">

                            <span class="text-xs text-slate-500 truncate mr-3">
                                {{ $sizes ?: 'No units listed' }}
                            </span>

                            <a
                                href="{{ route('houses.show', $house->id) }}"
                                class="shrink-0 text-xs font-semibold text-primary hover:text-dark transition-colors"
                            >
                                View →
                            </a>

                        </div>

                    </div>

                </article>

            @empty

                <div class="col-span-full bg-white border border-slate-200 rounded-xl py-16 px-6 text-center">

                    <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                        <svg
                            class="w-6 h-6 text-slate-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                            />
                        </svg>
                    </div>

                    <h3 class="font-semibold text-slate-900">
                        No houses found
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Try changing your search or filters.
                    </p>

                    <a
                        href="{{ route('houses.index') }}"
                        class="inline-block mt-4 text-sm font-semibold text-primary hover:text-dark"
                    >
                        Clear filters
                    </a>

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if(method_exists($houses, 'hasPages') && $houses->hasPages())

            <div class="mt-8">
                {{ $houses->withQueryString()->links() }}
            </div>

        @endif

    </div>
</div>
@endsection