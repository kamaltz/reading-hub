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
    <body class="font-sans antialiased">
        <div class="min-h-screen text-gray-200 bg-gray-900">
            <div class="flex h-screen">
                <!-- Sidebar -->
                <aside class="flex flex-col flex-shrink-0 w-64 border-r border-gray-800">
                    <div class="flex justify-center items-center h-20 border-b border-gray-800">
                        <a href="{{ route('dashboard') }}" class="text-3xl font-bold text-white">
                            Reading<span class="text-indigo-400">Hub</span>
                        </a>
                    </div>
                    <nav class="flex-grow p-4 space-y-2">
                        {{-- Link ke Dashboard --}}
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center rounded-lg px-4 py-2 transition-colors
                                  {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1V10a1 1 0 00-1-1H7a1 1 0 00-1 1v10a1 1 0 001 1h2z"/></svg>
                            <span>Dashboard</span>
                        </a>

                        {{-- Link ke Manajemen Materi --}}
                        <a href="{{ route('admin.materials.index') }}"
                           class="flex items-center rounded-lg px-4 py-2 transition-colors
                                  {{ request()->routeIs('admin.materials.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"/></svg>
                            <span>Materi Bacaan</span>
                        </a>

                        {{-- Link ke Manajemen Genre --}}
                        <a href="{{ route('admin.genres.index') }}"
                           class="flex items-center rounded-lg px-4 py-2 transition-colors
                                  {{ request()->routeIs('admin.genres.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm10 14h.01M17 11h5a2 2 0 012 2v5a2 2 0 01-2 2h-5a2 2 0 01-2-2v-5a2 2 0 012-2z"/></svg>
                            <span>Genre</span>
                        </a>

                        {{-- Link ke Manajemen Bab --}}
                        <a href="{{ route('admin.chapters.index') }}"
                           class="flex items-center rounded-lg px-4 py-2 transition-colors
                                  {{ request()->routeIs('admin.chapters.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            <span>Bab</span>
                        </a>

                        {{-- Link ke Manajemen Aktivitas --}}
                        <a href="{{ route('admin.activities.all') }}"
                           class="flex items-center rounded-lg px-4 py-2 transition-colors
                                  {{ request()->routeIs('admin.activities.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            <span>Aktivitas</span>
                        </a>

                    </nav>
                    <div class="p-4 border-t border-gray-800">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="flex items-center px-4 py-2 w-full text-gray-400 rounded-lg transition-colors hover:bg-red-900/50 hover:text-white">
                                <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span>Log Out</span>
                            </a>
                        </form>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="overflow-y-auto flex-1">
                    <!-- Top Bar -->
                    <div class="flex justify-end items-center p-4">
                         <a href="{{ route('profile.edit') }}" class="flex items-center focus:outline-none">
                            <span class="mr-2 text-white">{{ Auth::user()->name }}</span>
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                       </a>
                    </div>

                    <!-- Page Content Slot -->
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>