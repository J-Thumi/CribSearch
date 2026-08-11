@extends('layouts.app')

@section('content')
<!-- Header Banner -->
<div class="bg-dark text-white py-16 border-b border-gray-800">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-3 py-1 rounded bg-primary/20 text-primary text-xs font-bold uppercase tracking-widest mb-4">
            Legal & Compliance
        </span>
        <h1 class="text-3xl sm:text-5xl font-black uppercase tracking-tight">Privacy Policy</h1>
        <p class="text-gray-400 text-sm mt-3 font-light">
            Last Updated: August 11, 2026
        </p>
    </div>
</div>

<!-- Main Privacy Content -->
<div class="bg-bg py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-12 space-y-10 text-gray-700 leading-relaxed text-sm">
            
            <!-- Introduction -->
            <section class="space-y-3">
                <h2 class="text-xl font-black uppercase tracking-tight text-dark flex items-center gap-3">
                    <span class="w-2 h-6 bg-primary rounded-full"></span>
                    1. Introduction
                </h2>
                <p>
                    At <strong class="text-dark">{{ config('app.name', 'CribSearch') }}</strong> ("we," "our," or "us"), we are committed to respecting your privacy and protecting the personal data you share with us. This Privacy Policy explains how we collect, use, store, and disclose your personal information when you browse our property platform, request 360° virtual house tours, or book physical site visits across Kenya.
                </p>
                <p>
                    By accessing or using our website and services, you agree to the practices described in this policy, which complies with the <strong>Kenya Data Protection Act, 2019 (DPA)</strong>.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Information We Collect -->
            <section class="space-y-4">
                <h2 class="text-xl font-black uppercase tracking-tight text-dark flex items-center gap-3">
                    <span class="w-2 h-6 bg-primary rounded-full"></span>
                    2. Information We Collect
                </h2>
                <p>We collect information directly from you when you interact with our platform, as well as automatically through server logging and browser storage:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-xl bg-bg border border-gray-100">
                        <h3 class="font-bold text-dark text-xs uppercase tracking-wider mb-2 text-primary">A. Account & Booking Data</h3>
                        <ul class="list-disc list-inside space-y-1 text-xs text-gray-600">
                            <li>Full Name and Email Address</li>
                            <li>Phone Number (for visit coordination)</li>
                            <li>Account Passwords (encrypted via bcrypt)</li>
                            <li>Visit booking history and saved preferences</li>
                        </ul>
                    </div>

                    <div class="p-4 rounded-xl bg-bg border border-gray-100">
                        <h3 class="font-bold text-dark text-xs uppercase tracking-wider mb-2 text-primary">B. Technical & Scout Data</h3>
                        <ul class="list-disc list-inside space-y-1 text-xs text-gray-600">
                            <li>IP Address and browser metadata</li>
                            <li>API Auth Tokens stored in LocalStorage</li>
                            <li>Property location & geolocation queries</li>
                            <li>Agent credentials for scout portal verification</li>
                        </ul>
                    </div>
                </div>
            </section>

            <hr class="border-gray-100" />

            <!-- How We Use Your Information -->
            <section class="space-y-3">
                <h2 class="text-xl font-black uppercase tracking-tight text-dark flex items-center gap-3">
                    <span class="w-2 h-6 bg-primary rounded-full"></span>
                    3. How We Use Your Information
                </h2>
                <p>We process your personal information strictly for legitimate business and operational purposes:</p>
                <ul class="list-disc list-inside space-y-2 pl-2 text-gray-600">
                    <li><strong>Connecting Renters & Scouts:</strong> Facilitating property visit requests between users and verified agents.</li>
                    <li><strong>Authentication:</strong> Managing secure account access via Sanctum API bearer tokens.</li>
                    <li><strong>Service Improvement:</strong> Analyzing search trends and 360° virtual tour views to enhance listing accuracy.</li>
                    <li><strong>Fraud Prevention:</strong> Preventing duplicate listings, scam viewing fees, and unauthorized scout entries.</li>
                </ul>
            </section>

            <hr class="border-gray-100" />

            <!-- Information Sharing & Disclosure -->
            <section class="space-y-3">
                <h2 class="text-xl font-black uppercase tracking-tight text-dark flex items-center gap-3">
                    <span class="w-2 h-6 bg-primary rounded-full"></span>
                    4. Data Sharing & Disclosure
                </h2>
                <p>We do not sell, rent, or trade your personal data to third-party advertisers. We only share information under the following circumstances:</p>
                <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 space-y-2">
                    <p class="font-bold uppercase tracking-wider text-amber-800">Assigned Property Scouts</p>
                    <p>When you request a site visit for a specific house, your contact details (Name and Phone Number) are shared directly with the assigned property scout solely to coordinate your visit.</p>
                </div>
            </section>

            <hr class="border-gray-100" />

            <!-- Cookies and Local Storage -->
            <section class="space-y-3">
                <h2 class="text-xl font-black uppercase tracking-tight text-dark flex items-center gap-3">
                    <span class="w-2 h-6 bg-primary rounded-full"></span>
                    5. Cookies & Local Storage
                </h2>
                <p>
                    We use browser <code>localStorage</code> to store API access tokens (`auth_token`) so you remain logged in across sessions. We also utilize essential cookies for CSRF security protection. You can clear local storage or cookies at any time via your browser settings.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Data Security & Rights -->
            <section class="space-y-3">
                <h2 class="text-xl font-black uppercase tracking-tight text-dark flex items-center gap-3">
                    <span class="w-2 h-6 bg-primary rounded-full"></span>
                    6. Data Security & Your Rights
                </h2>
                <p>
                    Under the <strong>Kenya Data Protection Act</strong>, you have the right to request access to your personal data, request corrections, or ask for the total deletion of your user profile and booking history.
                </p>
                <p>
                    We implement industry-standard database encryption, HTTPS protocols, and hashed password storage to safeguard your credentials against unauthorized access.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Contact Support -->
            <section class="bg-dark text-white p-6 sm:p-8 rounded-2xl flex flex-col sm:flex-row justify-between items-center gap-6">
                <div>
                    <h3 class="text-lg font-black uppercase text-primary">Data Privacy Questions?</h3>
                    <p class="text-xs text-gray-400 mt-1">Contact our Data Protection Compliance team in Nairobi, Kenya.</p>
                </div>
                <a href="mailto:info@cribsearch.co.ke" class="px-6 py-3 bg-actionable hover:bg-primary text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-all shrink-0">
                    Email Privacy Team
                </a>
            </section>

        </div>

    </div>
</div>
@endsection