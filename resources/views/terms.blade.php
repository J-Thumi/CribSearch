<!-- resources/views/terms.blade.php -->
@extends('layouts.app')

@section('title', 'Terms of Service')

@section('content')
<!-- Header Banner with Hero Gradient Background -->
<div class="relative bg-gradient-to-b from-gray-900 via-gray-950 to-gray-900 text-white py-16 sm:py-20 border-b border-gray-800/80 overflow-hidden">
    <!-- Subtle Background Ambient Light Glow -->
    <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-amber-500/10 blur-[120px] pointer-events-none rounded-full"></div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-4 text-xs font-extrabold uppercase tracking-widest text-amber-500 justify-center items-center gap-2">
            <a href="{{ route('houses.index') }}" class="hover:text-amber-400 transition-colors">Home</a>
            <span class="text-gray-600">/</span>
            <span class="text-gray-400">Legal</span>
        </nav>

        <h1 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">Terms of Service</h1>
        <p class="text-gray-400 text-xs sm:text-sm mt-3 font-medium flex items-center justify-center gap-2">
            <svg class="w-4 h-4 text-amber-500/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Last Updated: August 2026
        </p>
    </div>
</div>

<!-- Main Terms Content -->
<div class="bg-gray-50/50 py-12 sm:py-16 font-sans">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Document Wrapper -->
        <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 p-6 sm:p-12 space-y-10 text-gray-700 leading-relaxed text-sm sm:text-base relative">
            
            <!-- Section 1: Intro -->
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    1. Acceptance of Terms
                </h2>
                <p>
                    By accessing or using our platform, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not access or use our services. These terms apply to all visitors, registered users, and scouts.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 2: Platform Services -->
            <section class="space-y-4">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    2. Platform Services & Digital Unlocks
                </h2>
                <p>
                    Our platform acts as a directory connecting users with housing options and verified scouts/caretakers.
                </p>
                
                <div class="grid grid-cols-1 gap-3 pt-1">
                    <div class="p-4 rounded-xl bg-gray-50/70 border border-gray-200/70 flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-amber-500 mt-2 shrink-0"></div>
                        <p class="text-xs sm:text-sm text-gray-600">Basic house details, public teasers, and general proximity info are available to all visitors.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200/70 flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-600 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <strong class="text-xs uppercase font-extrabold tracking-wider text-amber-900 block">Paid Unlocks</strong>
                            <p class="text-xs sm:text-sm text-amber-950/90 leading-relaxed">Accessing exact map coordinates, full travel time estimates, and direct caretaker contact information requires a digital payment (e.g., KES 100 via Bitika / M-Pesa STK Push).</p>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50/70 border border-gray-200/70 flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-amber-500 mt-2 shrink-0"></div>
                        <p class="text-xs sm:text-sm text-gray-600">Digital unlocks grant non-exclusive access to full property details. Payments are processed instantly via our payment provider.</p>
                    </div>
                </div>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 3: Payments & Refunds -->
            <section class="space-y-4">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    3. Payments & Refund Policy
                </h2>
                <p>
                    All payments for unlocking property information are final and non-refundable once direct caretaker details or map locations have been rendered accessible, except in cases where:
                </p>
                <ul class="space-y-2 text-xs sm:text-sm text-gray-600 pl-2">
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span>
                        An M-Pesa transaction was successfully processed, but digital access failed to activate due to a technical error on our side.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span>
                        A duplicate charge occurred for the same unlock session.
                    </li>
                </ul>
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 text-xs text-gray-600 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>If you experience payment issues, please contact support with your transaction reference number for manual activation or refund processing.</span>
                </div>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 4: User Accounts & Guest Access -->
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    4. User Accounts & Security
                </h2>
                <p>
                    Users may access properties as guests or via registered accounts. You are responsible for maintaining the confidentiality of your account credentials and for all activities conducted under your account.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 5: Listings & Accuracy Disclaimer -->
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    5. Accuracy of Listings
                </h2>
                <p>
                    While our scouts work diligently to verify property information, photos, 360° virtual tours, and availability statuses:
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <div class="p-4 rounded-xl bg-gray-50/60 border border-gray-100">
                        <strong class="block text-gray-900 text-xs font-bold uppercase tracking-wider mb-1">Dynamic Pricing & Availability</strong>
                        <p class="text-xs text-gray-600">Unit availability and prices are subject to change by property managers or caretakers without prior notice.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50/60 border border-gray-100">
                        <strong class="block text-gray-900 text-xs font-bold uppercase tracking-wider mb-1">In-Person Viewing Recommended</strong>
                        <p class="text-xs text-gray-600">We strongly recommend scheduling an in-person viewing with the assigned scout or caretaker prior to making any rental deposit.</p>
                    </div>
                </div>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 6: Prohibited Conduct -->
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    6. Prohibited Conduct
                </h2>
                <p>When using our site, you agree not to:</p>
                <ul class="space-y-2 text-xs sm:text-sm text-gray-600 pl-2">
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>
                        Scrape, duplicate, or re-sell caretaker contact numbers or property data unlocked through the platform.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>
                        Use the service for fraudulent viewing bookings or illegal activities.
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>
                        Attempt to circumvent digital access restrictions or security systems.
                    </li>
                </ul>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 7: Limitation of Liability -->
            <section class="space-y-3">
                <h2 class="text-lg sm:text-xl font-black uppercase tracking-tight text-gray-900 flex items-center gap-3">
                    <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                    7. Limitation of Liability
                </h2>
                <p>
                    Our platform acts as an intermediary information service. We are not a party to tenancy agreements between tenants, caretakers, and landlords. We are not liable for disputes, financial losses, or tenancy agreements made off the platform.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Section 8: Contact -->
            <section class="bg-gradient-to-r from-gray-900 via-gray-950 to-gray-900 text-white p-6 sm:p-8 rounded-2xl flex flex-col sm:flex-row justify-between items-center gap-6 shadow-xl relative overflow-hidden">
                <div class="relative z-10 text-center sm:text-left">
                    <h3 class="text-base sm:text-lg font-extrabold uppercase text-amber-400 tracking-wide">Customer Support</h3>
                    <p class="text-xs text-gray-300 mt-1 font-medium">Email: support@cribsearch.com</p>
                </div>
                <a href="mailto:support@cribsearch.com" class="relative z-10 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all duration-200 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 active:scale-95 shrink-0 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Contact Support
                </a>
            </section>

        </div>
    </div>
</div>
@endsection