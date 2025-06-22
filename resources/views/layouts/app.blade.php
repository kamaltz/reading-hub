<!DOCTYPE html>
{{-- Tambahkan x-data, x-init, dan :class di sini --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="themeSwitcher()" x-init="initTheme()" :class="{ 'dark': isDark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- Script untuk Theme Switcher (sudah termasuk di app.js, tapi kita definisikan fungsinya di sini) --}}
        {{-- Logika ini sekarang akan memprioritaskan 'light' sebagai default --}}
        <script>
            function themeSwitcher() {
                return {
                    isDark: false,
                    initTheme() {
                        // Hanya set ke dark jika 'dark' secara eksplisit ada di localStorage
                        if (localStorage.getItem('theme') === 'dark') {
                            this.isDark = true;
                        } else {
                            this.isDark = false;
                            localStorage.setItem('theme', 'light'); // Set default ke light
                        }
                    },
                    toggleTheme() {
                        this.isDark = !this.isDark;
                        localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
                    }
                }
            }
        </script>
    </body>
</html>