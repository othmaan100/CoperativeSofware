<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-emerald-50 via-slate-50 to-slate-50 dark:from-gray-800 dark:via-gray-900 dark:to-gray-900">
            <div class="flex flex-col items-center">
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20" />
                </a>
                <span class="mt-3 text-center leading-tight">
                    <span class="block text-base font-bold text-emerald-800 dark:text-emerald-400">FCE (T) Potiskum</span>
                    <span class="block text-xs text-slate-500 dark:text-slate-400">Staff Cooperative Society Limited</span>
                </span>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg border border-slate-100 dark:border-gray-700">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
