@extends('layouts.app')

@section('title', 'Terms of Service')

@section('content')
<div class="bg-bg min-h-screen py-12 font-sans">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-gray-100 shadow-sm mb-8 text-center sm:text-left">
            <nav class="flex mb-4 text-xs font-bold uppercase tracking-widest text-primary justify-center sm:justify-start">
                <a href="{{ route('houses.index') }}" class="hover:text-dark">Home</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-500">Legal</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-dark tracking-tight">Terms of Service</h1>
            <p class="text-sm text-gray-500 mt-2">Last Updated: August 2026</p>
        </div>

        <!-- Content Card -->
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm space-y-10 text-gray-700 leading-relaxed text-sm sm:text-base">
            
            <!-- Intro -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-dark">1. Acceptance of Terms</h2>
                <p>
                    By accessing or using our platform, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not access or use our services. These terms apply to all visitors, registered users, and scouts.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Platform Services -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-dark">2. Platform Services & Digital Unlocks</h2>
                <p>
                    Our platform acts as a directory connecting users with housing options and verified scouts/caretakers. 
                </p>
                <ul class="list-disc pl-5 space-y-2 text-gray-600">
                    <li>Basic house details, public teasers, and general proximity info are available to all visitors.</li>
                    <li>
                        <strong>Paid Unlocks:</strong> Accessing exact map coordinates, full travel time estimates, and direct caretaker contact information requires a digital payment (e.g., KES 100 via Bitika / M-Pesa STK Push).
                    </li>
                    <li>
                        Digital unlocks grant non-exclusive access to full property details. Payments are processed instantly via our payment provider.
                    </li>
                </ul>
            </section>

            <hr class="border-gray-100" />

            <!-- Payments & Refunds -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-dark">3. Payments & Refund Policy</h2>
                <p>
                    All payments for unlocking property information are final and non-refundable once direct caretaker details or map locations have been rendered accessible, except in cases where:
                </p>
                <ul class="list-disc pl-5 space-y-2 text-gray-600">
                    <li>An M-Pesa transaction was successfully processed, but digital access failed to activate due to a technical error on our side.</li>
                    <li>A duplicate charge occurred for the same unlock session.</li>
                </ul>
                <p class="text-xs text-gray-500 bg-bg p-4 rounded-xl border border-gray-200/80">
                    If you experience payment issues, please contact support with your transaction reference number for manual activation or refund processing.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- User Accounts & Guest Access -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-dark">4. User Accounts & Security</h2>
                <p>
                    Users may access properties as guests or via registered accounts. You are responsible for maintaining the confidentiality of your account credentials and for all activities conducted under your account.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Listings & Accuracy Disclaimer -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-dark">5. Accuracy of Listings</h2>
                <p>
                    While our scouts work diligently to verify property information, photos, 360° virtual tours, and availability statuses:
                </p>
                <ul class="list-disc pl-5 space-y-2 text-gray-600">
                    <li>Unit availability and prices are subject to change by property managers or caretakers without prior notice.</li>
                    <li>We strongly recommend scheduling an in-person viewing with the assigned scout or caretaker prior to making any rental deposit or sign-on agreement with property owners.</li>
                </ul>
            </section>

            <hr class="border-gray-100" />

            <!-- Prohibited Conduct -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-dark">6. Prohibited Conduct</h2>
                <p>When using our site, you agree not to:</p>
                <ul class="list-disc pl-5 space-y-2 text-gray-600">
                    <li>Scrape, duplicate, or re-sell caretaker contact numbers or property data unlocked through the platform.</li>
                    <li>Use the service for fraudulent viewing bookings or illegal activities.</li>
                    <li>Attempt to circumvent digital access restrictions or security systems.</li>
                </ul>
            </section>

            <hr class="border-gray-100" />

            <!-- Limitation of Liability -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-dark">7. Limitation of Liability</h2>
                <p>
                    Our platform acts as an intermediary information service. We are not a party to tenancy agreements between tenants, caretakers, and landlords. We are not liable for disputes, financial losses, or tenancy agreements made off the platform.
                </p>
            </section>

            <hr class="border-gray-100" />

            <!-- Contact -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-dark">8. Contact Us</h2>
                <p>
                    If you have questions regarding these Terms of Service or need payment support, please reach out to our team at:
                </p>
                <div class="p-4 bg-bg border border-gray-200/80 rounded-2xl flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <p class="font-bold text-dark text-sm">Customer Support</p>
                        <p class="text-xs text-gray-500">Email: support@cribsearch.com</p>
                    </div>
                    <a href="mailto:support@cribsearch.com" class="px-5 py-2.5 bg-primary text-white font-bold text-xs rounded-xl hover:bg-dark transition">
                        Contact Support
                    </a>
                </div>
            </section>

        </div>
    </div>
</div>
@endsection