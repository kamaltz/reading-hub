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
        <x-head.tinymce-config/>
        {{-- AlpineJS untuk state management --}}
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        {{-- Inisialisasi AlpineJS: sidebar terbuka di desktop (lebar > 1024px), tertutup di mobile --}}
        <div x-data="{ sidebarOpen: window.innerWidth > 1024 }" class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="flex h-screen bg-gray-100 dark:bg-gray-900">

                <!-- Backdrop Overlay untuk Mobile -->
                <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"></div>

                <!-- Sidebar -->
                <aside 
                    x-show="sidebarOpen"
                    x-transition:enter="transition-transform ease-in-out duration-300"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition-transform ease-in-out duration-300"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="flex overflow-y-auto fixed inset-y-0 left-0 z-30 flex-col flex-shrink-0 w-64 bg-white border-r dark:bg-gray-800 dark:border-gray-700 lg:static lg:flex">
                    
                    <div class="flex flex-shrink-0 justify-center items-center h-20 border-b dark:border-gray-700">
                        <a href="{{ route('dashboard') }}" class="text-3xl font-bold text-gray-800 dark:text-white">
                            Reading<span class="text-indigo-600 dark:text-indigo-400">Hub</span>
                        </a>
                    </div>

                    {{-- ================================================= --}}
                    {{--         MENU ANDA YANG SUDAH ADA DIMASUKKAN KE SINI       --}}
                    {{-- ================================================= --}}
                    <nav class="flex-grow p-4 space-y-2 text-gray-600 dark:text-gray-400">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('dashboard') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                           <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1V10a1 1 0 00-1-1H7a1 1 0 00-1 1v10a1 1 0 001 1h2z"/></svg>
                            <span>Dashboard</span>
                        </a>

                        @if(Auth::check())
                            {{-- Menu Khusus Admin --}}
                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('admin.materials.index') }}"
                                   class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('admin.materials.*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                   <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"/></svg>
                                    <span>Materi Bacaan</span>
                                </a>
                                <a href="{{ route('admin.genres.index') }}"
                                   class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('admin.genres.*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                   <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm10 14h.01M17 11h5a2 2 0 012 2v5a2 2 0 01-2 2h-5a2 2 0 01-2-2v-5a2 2 0 012-2z"/></svg>
                                    <span>Genre</span>
                                </a>
                                <a href="{{ route('admin.chapters.index') }}"
                                   class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('admin.chapters.*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                   <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                    <span>Bab</span>
                                </a>
                                <a href="{{ route('admin.activities.all') }}"
                                   class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('admin.activities.*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                   <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                    <span>Aktivitas</span>
                                </a>
                                <a href="{{ route('admin.students.index') }}"
                                   class="flex items-center px-4 py-2 transition-colors rounded-lg {{ request()->routeIs('admin.students.*') ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                   <svg class="mr-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197" /></svg>
                                    <span>Siswa</span>
                                </a>

                            {{-- Menu Khusus Siswa --}}
                            @else
                                {{-- <a href="{{ route('student.activities.index') }}" ... --}}
                            @endif
                        @endif
                    </nav>
                    {{-- ================================================= --}}
                    {{--               MENU ANDA BERAKHIR DI SINI            --}}
                    {{-- ================================================= --}}
                    
                    <div class="flex-shrink-0 p-4 border-t dark:border-gray-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="flex items-center px-4 py-2 w-full text-gray-600 rounded-lg transition-colors dark:text-gray-400 hover:bg-red-100 dark:hover:bg-red-900/50 hover:text-red-700 dark:hover:text-white">
                               <svg class="mr-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span>Log Out</span>
                            </a>
                        </form>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="flex overflow-hidden flex-col flex-1">
                    <!-- Top Bar -->
                    <header class="flex justify-between items-center p-4 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <!-- Tombol Toggle Sidebar -->
                        <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-500 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </button>
                        
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <a href="{{ route('profile.edit') }}" class="flex items-center focus:outline-none">
                                <span class="mr-2 text-gray-700 dark:text-gray-300">{{ Auth::user()->name ?? 'Guest' }}</span>
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </a>
                        </div>
                    </header>

                    <!-- Page Content Slot -->
                    <main class="overflow-y-auto overflow-x-hidden flex-1 bg-gray-100 dark:bg-gray-900">
                        <div class="container px-6 py-8 mx-auto">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        </div>
        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    </body>
</html>
