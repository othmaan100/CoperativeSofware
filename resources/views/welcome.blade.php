<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} — FCE (T) Potiskum Staff Cooperative Society</title>
        <meta name="description" content="The official member portal of the Federal College of Education (Technical), Potiskum Staff Cooperative Society Limited — savings, shares, loans and dividends, managed transparently.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 dark:text-slate-100 bg-white dark:bg-gray-900">

        {{-- ============ Top Navigation ============ --}}
        <header class="border-b border-slate-100 dark:border-gray-800 sticky top-0 z-30 bg-white/90 dark:bg-gray-900/90 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    <x-application-logo class="h-10 w-10" />
                    <span class="leading-tight">
                        <span class="block text-sm font-bold text-emerald-800 dark:text-emerald-400">FCE (T) Potiskum</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400 -mt-0.5">Staff Cooperative Society Ltd</span>
                    </span>
                </a>

                <nav class="flex items-center gap-2 sm:gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-600 transition">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition">
                            Member Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-600 transition">
                            Apply for Membership
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        {{-- ============ Hero ============ --}}
        <section class="relative overflow-hidden bg-gradient-to-b from-emerald-50 via-white to-white dark:from-gray-800 dark:via-gray-900 dark:to-gray-900">
            <div class="absolute inset-0 pointer-events-none opacity-[0.35] dark:opacity-[0.12]" aria-hidden="true">
                <svg class="absolute -top-24 -right-24 w-[36rem] h-[36rem] text-emerald-200 dark:text-emerald-900" fill="currentColor" viewBox="0 0 200 200">
                    <circle cx="100" cy="100" r="100" />
                </svg>
                <svg class="absolute -bottom-32 -left-16 w-[28rem] h-[28rem] text-amber-100 dark:text-amber-900" fill="currentColor" viewBox="0 0 200 200">
                    <circle cx="100" cy="100" r="100" />
                </svg>
            </div>

            <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 text-center">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 text-xs font-semibold tracking-wide uppercase">
                    Federal College of Education (Technical), Potiskum
                </span>

                <h1 class="mt-6 text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Building Financial Strength,<br class="hidden sm:block"> Together.
                </h1>

                <p class="mt-5 max-w-2xl mx-auto text-lg text-slate-600 dark:text-slate-300">
                    The official cooperative society for the staff of FCE (T) Potiskum — a member-owned platform for
                    disciplined savings, share capital, affordable loans and yearly dividends, all managed with full
                    transparency.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-emerald-700 text-white font-semibold rounded-md shadow-sm hover:bg-emerald-600 transition">
                            Go to My Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-emerald-700 text-white font-semibold rounded-md shadow-sm hover:bg-emerald-600 transition">
                            Apply for Membership
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-white dark:bg-gray-800 text-emerald-800 dark:text-emerald-400 font-semibold rounded-md border border-emerald-200 dark:border-gray-700 hover:border-emerald-400 transition">
                            Member Login
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        {{-- ============ Stats ============ --}}
        <section class="border-y border-slate-100 dark:border-gray-800 bg-white dark:bg-gray-900">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div>
                    <p class="text-3xl font-extrabold text-emerald-700 dark:text-emerald-400">{{ number_format($activeMembers) }}</p>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Active Members</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-emerald-700 dark:text-emerald-400">₦{{ number_format($totalSavings, 0) }}</p>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Total Savings Under Management</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-emerald-700 dark:text-emerald-400">{{ number_format($departments) }}</p>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Departments Represented</p>
                </div>
            </div>
        </section>

        {{-- ============ What we offer ============ --}}
        <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">What the Society Offers</h2>
                <p class="mt-3 text-slate-600 dark:text-slate-400">Every naira saved and every record kept is posted, traceable and auditable — never edited away.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 rounded-xl border border-slate-100 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition">
                    <div class="h-11 w-11 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-700 dark:text-emerald-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .672-3 1.5S10.343 11 12 11s3 .672 3 1.5-1.343 1.5-3 1.5m0-6V6m0 8v1.5m0-11a9 9 0 100 18 9 9 0 000-18z" /></svg>
                    </div>
                    <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">Savings &amp; Contributions</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Monthly salary-deducted savings and voluntary top-ups, with instant statements.</p>
                </div>

                <div class="p-6 rounded-xl border border-slate-100 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition">
                    <div class="h-11 w-11 rounded-lg bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m-6 4h6m-6 4h4M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" /></svg>
                    </div>
                    <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">Share Capital</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Build equity in the society and grow your stake as a co-owner, not just a saver.</p>
                </div>

                <div class="p-6 rounded-xl border border-slate-100 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition">
                    <div class="h-11 w-11 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-700 dark:text-emerald-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a4 4 0 00-8 0v2M5 9h14l1 11H4L5 9z" /></svg>
                    </div>
                    <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">Affordable Loans</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Access credit facilities against your savings and shares, guaranteed by fellow members.</p>
                </div>

                <div class="p-6 rounded-xl border border-slate-100 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition">
                    <div class="h-11 w-11 rounded-lg bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m-4-4l4 4 4-4M8 7l4-4 4 4" /></svg>
                    </div>
                    <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">Yearly Dividends</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Share in the society's surplus at the end of every financial year.</p>
                </div>
            </div>
        </section>

        {{-- ============ How to join ============ --}}
        <section class="bg-slate-50 dark:bg-gray-800/40 border-y border-slate-100 dark:border-gray-800">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center max-w-2xl mx-auto">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">How to Join</h2>
                    <p class="mt-3 text-slate-600 dark:text-slate-400">From application to active member in three simple, controlled steps.</p>
                </div>

                <div class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="mx-auto h-12 w-12 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center">1</div>
                        <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">Submit Your Application</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Complete the online membership form with your staff and next-of-kin details.</p>
                    </div>
                    <div class="text-center">
                        <div class="mx-auto h-12 w-12 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center">2</div>
                        <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">Treasurer Review</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">The Treasurer verifies your details and confirms your monthly contribution.</p>
                    </div>
                    <div class="text-center">
                        <div class="mx-auto h-12 w-12 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center">3</div>
                        <h3 class="mt-4 font-semibold text-slate-900 dark:text-white">Start Saving</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Receive your membership number and track everything from your dashboard.</p>
                    </div>
                </div>

                @guest
                    <div class="mt-12 text-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-emerald-700 text-white font-semibold rounded-md shadow-sm hover:bg-emerald-600 transition">
                            Start Your Application
                        </a>
                    </div>
                @endguest
            </div>
        </section>

        {{-- ============ Footer ============ --}}
        <footer class="bg-slate-900 text-slate-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 sm:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-9 w-9" />
                        <span class="font-bold text-white">FCE (T) Potiskum<br>Staff Cooperative Society Ltd</span>
                    </div>
                    <p class="mt-4 text-sm text-slate-400">
                        Federal College of Education (Technical), Potiskum, Yobe State, Nigeria.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wide">Quick Links</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="{{ route('register') }}" class="hover:text-emerald-400 transition">Apply for Membership</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition">Member Login</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wide">Our Commitment</h4>
                    <p class="mt-4 text-sm text-slate-400">
                        Every balance in this system is derived from posted transactions. Corrections are made only
                        through controlled reversals — records are never silently altered.
                    </p>
                </div>
            </div>
            <div class="border-t border-slate-800">
                <p class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-slate-500">
                    &copy; {{ now()->year }} FCE (T) Potiskum Staff Cooperative Society Limited. All rights reserved.
                </p>
            </div>
        </footer>
    </body>
</html>
