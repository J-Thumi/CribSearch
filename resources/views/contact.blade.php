@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-50">

{{-- Hero --}}
<section class="relative overflow-hidden bg-slate-900">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-amber-400 blur-3xl"></div>
        <div class="absolute -bottom-32 -left-20 h-80 w-80 rounded-full bg-amber-500 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8 lg:py-20">

        <div class="max-w-2xl">
            <span class="inline-flex items-center rounded-full bg-amber-400/10 px-4 py-2 text-sm font-semibold text-amber-400 ring-1 ring-inset ring-amber-400/20">
                We're here to help
            </span>

            <h1 class="mt-5 text-4xl font-black tracking-tight text-white sm:text-5xl">
                Have a question?
                <span class="text-amber-400">Talk to us.</span>
            </h1>

            <p class="mt-5 max-w-xl text-base leading-7 text-slate-300 sm:text-lg">
                Whether you're looking for a house, need help with your
                CribSearch account, or have feedback for us, we'd love to
                hear from you.
            </p>
        </div>

    </div>
</section>


{{-- Main Content --}}
<section class="mx-auto max-w-7xl px-5 py-12 sm:px-6 lg:px-8 lg:py-16">

    <div class="grid gap-8 lg:grid-cols-3">

        {{-- Contact Information --}}
        <div class="space-y-6">

            <div>
                <p class="text-sm font-bold uppercase tracking-wider text-amber-600">
                    Contact us
                </p>

                <h2 class="mt-2 text-2xl font-black text-slate-900">
                    Let's get you sorted.
                </h2>

                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Reach out through any of the channels below and
                    we'll get back to you as soon as possible.
                </p>
            </div>


            {{-- Phone --}}
            <a
                href="tel:+254769326488"
                class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-200 hover:shadow-md"
            >
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.7 2.8a2 2 0 01-.45 1.84L8.91 10.72a16.001 16.001 0 004.37 4.37l1.565-1.56a2 2 0 011.84-.45l2.8.7A2 2 0 0121 15.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>

                <div>
                    <p class="font-bold text-slate-900">
                        Call us
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        +254 769 326 488
                    </p>
                </div>
            </a>


            {{-- Email --}}
            <a
                href="mailto:support@cribsearch.co.ke"
                class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-200 hover:shadow-md"
            >
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>

                <div>
                    <p class="font-bold text-slate-900">
                        Email us
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        support@cribsearch.co.ke
                    </p>
                </div>
            </a>


            {{-- WhatsApp --}}
            <a
                href="https://wa.me/254769326488"
                target="_blank"
                rel="noopener noreferrer"
                class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-200 hover:shadow-md"
            >
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 11.5a8.38 8.38 0 01-9 8.5 8.5 8.5 0 01-3.8-.9L3 21l1.9-4.9A8.5 8.5 0 1112 20"/>
                    </svg>
                </div>

                <div>
                    <p class="font-bold text-slate-900">
                        WhatsApp
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        Chat with our support team
                    </p>
                </div>
            </a>


            {{-- Response time --}}
            <div class="rounded-2xl bg-amber-50 p-5 ring-1 ring-inset ring-amber-100">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-bold text-slate-900">
                            Quick response
                        </p>

                        <p class="text-xs text-slate-600">
                            We usually respond within 24 hours.
                        </p>
                    </div>
                </div>
            </div>

        </div>


        {{-- Contact Form --}}
        <div class="lg:col-span-2">

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

                <div class="mb-7">
                    <h2 class="text-2xl font-black text-slate-900">
                        Send us a message
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        Fill in the form below and our team will get back to you.
                    </p>
                </div>


                @if(session('success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                        {{ session('success') }}
                    </div>
                @endif


                @if($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                        <ul class="space-y-1 text-sm text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form
                    method="POST"
                    action="{{ route('contact.store') }}"
                    class="space-y-6"
                >
                    @csrf

                    <div class="grid gap-6 sm:grid-cols-2">

                        <div>
                            <label
                                for="name"
                                class="mb-2 block text-sm font-bold text-slate-700"
                            >
                                Your name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', auth()->user()->name ?? '') }}"
                                required
                                placeholder="John Doe"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-500/10"
                            >
                        </div>


                        <div>
                            <label
                                for="email"
                                class="mb-2 block text-sm font-bold text-slate-700"
                            >
                                Email address
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                required
                                placeholder="you@example.com"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-500/10"
                            >
                        </div>

                    </div>


                    <div>
                        <label
                            for="subject"
                            class="mb-2 block text-sm font-bold text-slate-700"
                        >
                            Subject
                        </label>

                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            value="{{ old('subject') }}"
                            required
                            placeholder="How can we help?"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-500/10"
                        >
                    </div>


                    <div>
                        <label
                            for="message"
                            class="mb-2 block text-sm font-bold text-slate-700"
                        >
                            Message
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            required
                            placeholder="Tell us how we can help..."
                            class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-amber-500 focus:bg-white focus:ring-4 focus:ring-amber-500/10"
                        >{{ old('message') }}</textarea>
                    </div>


                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <p class="text-xs leading-5 text-slate-400">
                            We'll only use your information to respond to your enquiry.
                        </p>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-6 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-amber-600 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-amber-500/20 active:scale-[0.98]"
                        >
                            Send message

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 12h14M13 6l6 6-6 6"
                                />
                            </svg>
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>


{{-- Bottom CTA --}}
<section class="border-t border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-5 py-10 sm:px-6 lg:px-8">

        <div class="flex flex-col items-start justify-between gap-5 sm:flex-row sm:items-center">

            <div>
                <h2 class="text-lg font-black text-slate-900">
                    Looking for a house instead?
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Browse available houses around your campus and find your next crib.
                </p>
            </div>

            <a
                href="{{ url('/houses') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800"
            >
                Browse houses

                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 12h14M13 6l6 6-6 6"
                    />
                </svg>
            </a>

        </div>

    </div>
</section>

</div>

@endsection
