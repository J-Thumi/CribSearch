<!-- resources/views/privacy-policy.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Header Banner with Hero Gradient Background -->
<div class="relative bg-gradient-to-b from-gray-900 via-gray-950 to-gray-900 text-white py-16 sm:py-20 border-b border-gray-800/80 overflow-hidden">
    <!-- Subtle Background Ambient Light Glow -->
    <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-amber-500/10 blur-[120px] pointer-events-none rounded-full"></div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-500 text-xs font-bold uppercase tracking-widest mb-4 backdrop-blur-md">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Legal & Compliance
        </span>
        <h1 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">Privacy Policy</h1>
        <p class="text-gray-400 text-xs sm:text-sm mt-3 font-medium flex items-center justify-center gap-2">
            <svg class="w-4 h-4 text-amber-500/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Last Updated: August 11, 2026
        </p>
    </div>
</div>

<!-- Main Privacy Content -->
<div class="bg-gray-50/50 py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Document Wrapper -->
        <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 p-6 sm:p-12 space-y-10 text-gray-700 leading-relaxed text-sm relative">
            
            <!-- Section 1: Introduction -->
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    1. Introduction
                </h2>
                <p>
                    At <strong class="text-gray-900 font-bold">{{ config('app.name', 'CribSearch') }}</strong> ("we," "our," or "us"), we are committed to respecting your privacy and protecting the personal data you share with us. This Privacy Policy explains how we collect, use, store, and disclose your personal information when you browse our property platform, request 360° virtual house tours, or book physical site visits across Kenya.
                </p>
                <p>
                    By accessing or using our website and services, you agree to the practices described in this policy, which complies with the <strong class="text-gray-900 font-semibold">Kenya Data Protection Act, 2019 (DPA)</strong>.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 2: Information We Collect -->
            <section class="space-y-4">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    2. Information We Collect
                </h2>
                <p>We collect information directly from you when you interact with our platform, as well as automatically through server logging and browser storage:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <!-- Data Box A -->
                    <div class="p-5 rounded-2xl bg-gray-50/80 border border-gray-200/70 hover:border-amber-500/30 transition-all duration-200">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-7 h-7 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h3 class="font-extrabold text-gray-900 text-xs uppercase tracking-wider">A. Account & Booking Data</h3>
                        </div>
                        <ul class="space-y-2 text-xs text-gray-600">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Full Name and Email Address
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Phone Number (for visit coordination)
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Account Passwords (encrypted via bcrypt)
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Visit booking history and saved preferences
                            </li>
                        </ul>
                    </div>

                    <!-- Data Box B -->
                    <div class="p-5 rounded-2xl bg-gray-50/80 border border-gray-200/70 hover:border-amber-500/30 transition-all duration-200">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-7 h-7 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                </svg>
                            </div>
                            <h3 class="font-extrabold text-gray-900 text-xs uppercase tracking-wider">B. Technical & Scout Data</h3>
                        </div>
                        <ul class="space-y-2 text-xs text-gray-600">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                IP Address and browser metadata
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                API Auth Tokens stored in LocalStorage
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Property location & geolocation queries
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Agent credentials for scout portal verification
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 3: How We Use Your Information -->
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    3. How We Use Your Information
                </h2>
                <p>We process your personal information strictly for legitimate business and operational purposes:</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                        <strong class="block text-gray-900 text-xs font-bold uppercase tracking-wider mb-1">Connecting Renters & Scouts</strong>
                        <p class="text-xs text-gray-600">Facilitating property visit requests between users and verified agents.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                        <strong class="block text-gray-900 text-xs font-bold uppercase tracking-wider mb-1">Authentication</strong>
                        <p class="text-xs text-gray-600">Managing secure account access via Sanctum API bearer tokens.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                        <strong class="block text-gray-900 text-xs font-bold uppercase tracking-wider mb-1">Service Improvement</strong>
                        <p class="text-xs text-gray-600">Analyzing search trends and 360° virtual tour views to enhance listing accuracy.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100">
                        <strong class="block text-gray-900 text-xs font-bold uppercase tracking-wider mb-1">Fraud Prevention</strong>
                        <p class="text-xs text-gray-600">Preventing duplicate listings, scam viewing fees, and unauthorized scout entries.</p>
                    </div>
                </div>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 4: Data Sharing & Disclosure -->
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    4. Data Sharing & Disclosure
                </h2>
                <p>We do not sell, rent, or trade your personal data to third-party advertisers. We only share information under the following circumstances:</p>
                
                <div class="p-5 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-xs text-amber-950 space-y-2 relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 opacity-10">
                        <svg class="w-32 h-32 text-amber-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14h2v2h-2zm0-10h2v8h-2z"/>
                        </svg>
                    </div>
                    <p class="font-extrabold uppercase tracking-wider text-amber-900 flex items-center gap-2 text-xs">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Assigned Property Scouts
                    </p>
                    <p class="text-amber-900/90 leading-relaxed">When you request a site visit for a specific house, your contact details (Name and Phone Number) are shared directly with the assigned property scout solely to coordinate your visit.</p>
                </div>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 5: Cookies & Local Storage -->
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    5. Cookies & Local Storage
                </h2>
                <p>
                    We use browser <code class="px-2 py-0.5 rounded bg-gray-100 text-amber-700 font-mono text-xs border border-gray-200">localStorage</code> to store API access tokens (`auth_token`) so you remain logged in across sessions. We also utilize essential cookies for CSRF security protection. You can clear local storage or cookies at any time via your browser settings.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 6: Data Security & Your Rights -->
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    6. Data Security & Your Rights
                </h2>
                <p>
                    Under the <strong class="text-gray-900 font-bold">Kenya Data Protection Act</strong>, you have the right to request access to your personal data, request corrections, or ask for the total deletion of your user profile and booking history.
                </p>
                <p>
                    We implement industry-standard database encryption, HTTPS protocols, and hashed password storage to safeguard your credentials against unauthorized access.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Contact Support Section -->
            <section class="bg-gradient-to-r from-gray-900 via-gray-950 to-gray-900 text-white p-6 sm:p-8 rounded-2xl flex flex-col sm:flex-row justify-between items-center gap-6 shadow-xl relative overflow-hidden">
                <div class="relative z-10 text-center sm:text-left">
                    <h3 class="text-base sm:text-lg font-extrabold uppercase text-amber-400 tracking-wide">Data Privacy Questions?</h3>
                    <p class="text-xs text-gray-300 mt-1 font-medium">Contact our Data Protection Compliance team in Nairobi, Kenya.</p>
                </div>
                <a href="mailto:info@cribsearch.co.ke" class="relative z-10 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 active:scale-95 shrink-0 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Email Privacy Team
                </a>
            </section>

        </div>

    </div>
</div>
@endsection