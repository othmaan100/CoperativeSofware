<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-10">
            <div class="max-w-3xl mx-auto px-4">
                <div class="flex items-center justify-center mb-6">
                    <a href="/" wire:navigate class="flex flex-col items-center">
                        <x-application-logo class="w-16 h-16 fill-current text-gray-500" />
                        <span class="mt-2 text-sm font-semibold text-gray-600 dark:text-gray-300 text-center">
                            FCE (T) Potiskum Staff Cooperative Society Ltd
                        </span>
                    </a>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg px-6 py-6 sm:px-8 sm:py-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
