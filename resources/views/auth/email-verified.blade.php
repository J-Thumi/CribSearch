@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-lg">

        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-8 sm:p-10 text-center">

            {{-- Success Icon --}}
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-green-100">
                <svg
                    class="h-10 w-10 text-green-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    />
                </svg>
            </div>

            {{-- Heading --}}
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                Email Verified!
            </h1>

            {{-- Message --}}
            <p class="mt-4 text-slate-600 leading-relaxed">
                Thank you, <span class="font-semibold text-slate-900">{{ auth()->user()->name }}</span>.
                Your email address has been successfully verified.
            </p>

            <p class="mt-2 text-slate-500 text-sm">
                Your CribSearch account is now ready. You can continue searching
                for your next place to call home.
            </p>

            {{-- Buttons --}}
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">

                <a
                    href="{{ route('houses.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl
                           bg-blue-600 text-white font-bold
                           hover:bg-blue-700 transition"
                >
                    Continue Searching
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"
                        />
                    </svg>
                </a>

                <a
                    href="{{ route('profile') }}"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl
                           border border-slate-300 text-slate-700 font-semibold
                           hover:bg-slate-50 transition"
                >
                    View Profile
                </a>

            </div>

        </div>

        {{-- Small reassurance --}}
        <p class="text-center text-xs text-slate-400 mt-5">
            Your email has been verified successfully.
        </p>

    </div>

</div>
@endsection