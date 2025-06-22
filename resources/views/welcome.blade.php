<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reading Hub</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        {{-- Navigasi Atas --}}
        <header class="bg-white dark:bg-gray-800 shadow">
            <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800 dark:text-white">Reading Hub</a>
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            </nav>
        </header>

        {{-- Konten Utama --}}
        <main class="container mx-auto px-6 py-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Materi Bacaan</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($materials as $material)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300">
                        <a href="{{ route('materials.show', $material) }}">
                            @if ($material->illustration_path)
                                <img src="{{ asset('storage/' . $material->illustration_path) }}" alt="{{ $material->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $material->genre->name }}</span>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-2">{{ $material->title }}</h2>
                                <p class="text-gray-600 dark:text-gray-300 mt-2">{{ Str::limit(strip_tags($material->content), 100) }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-3">Belum ada materi yang tersedia.</p>
                @endforelse
            </div>
            
            {{-- Navigasi Paginasi --}}
            <div class="mt-8">
                {{ $materials->links() }}
            </div>
        </main>
    </body>
</html>