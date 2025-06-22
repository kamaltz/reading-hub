<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data="themeSwitcher()" x-init="initTheme()" :class="{ 'dark': isDark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reading Hub - Gateway to Knowledge</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900 transition-colors duration-300">

    <header class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg shadow-sm">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-gray-800 dark:text-white">Reading<span class="text-indigo-500">Hub</span></a>
            <div class="flex items-center space-x-4">
                <button @click="toggleTheme()" type="button" class="p-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg x-show="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg x-show="isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-semibold bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-500 transition">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hidden sm:inline-block px-4 py-2 text-sm font-semibold bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition">Get Started</a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <main>
        <section class="relative h-[60vh] md:h-[80vh] flex items-center justify-center text-center text-white overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1495446815901-a7297e633e8d?q=80&w=2070&auto=format&fit=crop');"></div>
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="relative z-10 p-6" x-data="{ visible: false }" x-intersect="visible = true">
                <h1 x-show="visible" x-transition:enter.duration.1000ms class="text-4xl md:text-6xl font-extrabold tracking-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.7);">Tingkatkan Wawasan Anda</h1>
                <p x-show="visible" x-transition:enter.delay.500ms.duration.1000ms class="mt-4 text-lg md:text-xl max-w-3xl mx-auto" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.7);">Jelajahi beragam materi bacaan yang dirancang untuk memperkaya pengetahuan dan mengasah kemampuan berpikir kritis Anda.</p>
                <a x-show="visible" x-transition:enter.delay.1000ms.duration.1000ms href="#features" class="mt-8 inline-block bg-indigo-500 text-white font-bold py-3 px-8 rounded-full hover:bg-indigo-600 transition-transform transform hover:scale-105 shadow-2xl">Lihat Fitur</a>
            </div>
        </section>

        <section id="features" class="py-16 sm:py-24 bg-gray-50 dark:bg-gray-800">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Mengapa ReadingHub?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Kami menyediakan platform belajar yang modern dan efektif.</p>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="flex flex-col items-center" x-data="{}" x-intersect:enter="$el.classList.add('animate-fade-in-up')">
                        <div class="p-4 bg-indigo-100 dark:bg-indigo-900/50 rounded-full text-indigo-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">Konten Berbasis Genre</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Pelajari berbagai jenis teks, mulai dari naratif hingga ekspositori, sesuai kurikulum.</p>
                    </div>
                    <div class="flex flex-col items-center" x-data="{}" x-intersect:enter.delay.200ms="$el.classList.add('animate-fade-in-up')">
                        <div class="p-4 bg-indigo-100 dark:bg-indigo-900/50 rounded-full text-indigo-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0m-8.485-2.829l-.707.707"></path></svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">Aktivitas HOTS</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Latih kemampuan berpikir tingkat tinggi dengan soal-soal interaktif yang menantang.</p>
                    </div>
                    <div class="flex flex-col items-center" x-data="{}" x-intersect:enter.delay.400ms="$el.classList.add('animate-fade-in-up')">
                        <div class="p-4 bg-indigo-100 dark:bg-indigo-900/50 rounded-full text-indigo-500">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">Ilustrasi Menarik</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Visual yang relevan membantu memperdalam pemahaman dan membuat belajar lebih menyenangkan.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 sm:py-24 bg-white dark:bg-gray-800/50">
             <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                     <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Materi Unggulan</h2>
                     <p class="text-gray-500 dark:text-gray-400 mt-2">Materi yang paling sering diakses oleh pengguna lain.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($materials as $material)
                        <div x-data="{}" x-intersect:enter="$el.classList.add('animate-scale-in')" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-indigo-500/20 hover:-translate-y-2 transition-all duration-300 ease-in-out border border-gray-200 dark:border-gray-700 overflow-hidden">
                             <a href="{{ route('materials.show', $material) }}" class="block">
                                <div class="relative">
                                    <img src="{{ $material->illustration_path ? asset('storage/' . $material->illustration_path) : 'https://placehold.co/600x400/e2e8f0/e2e8f0' }}" alt="{{ $material->title }}" class="w-full h-56 object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <h3 class="absolute bottom-4 left-4 text-xl font-bold text-white">{{ $material->title }}</h3>
                                    <span class="absolute top-4 right-4 bg-indigo-500 text-white text-xs font-semibold px-3 py-1 rounded-full">{{ $material->genre->name }}</span>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-3 text-center">Belum ada materi unggulan.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
    
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-6 py-12">
             <div class="text-center">
                 <a href="#" class="text-2xl font-bold">Reading<span class="text-indigo-400">Hub</span></a>
                 <p class="mt-4 text-gray-400">Platform pembelajaran Bahasa Inggris untuk masa depan.</p>
                 <div class="mt-6">
                     <a href="{{ route('register') }}" class="bg-indigo-500 text-white font-bold py-3 px-6 rounded-full hover:bg-indigo-600 transition">Mulai Sekarang, Gratis!</a>
                 </div>
             </div>
             <div class="mt-10 border-t border-gray-700 pt-6 text-center text-sm text-gray-500">
                 <p>&copy; {{ date('Y') }} ReadingHub. Dibuat dengan passion di Garut, Indonesia.</p>
             </div>
        </div>
    </footer>
    
    {{-- Script untuk Alpine.js Intersect Plugin (Animation on Scroll) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Script untuk Theme Switcher --}}
    <script>
        function themeSwitcher() {
            return {
                isDark: localStorage.getItem('theme') === 'dark',
                initTheme() {
                    if (localStorage.getItem('theme') === 'dark' || 
                       (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                        this.isDark = true;
                    } else {
                        this.isDark = false;
                    }
                },
                toggleTheme() {
                    this.isDark = !this.isDark;
                    localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
                }
            }
        }
    </script>
    
    {{-- Menambahkan custom keyframes untuk animasi --}}
    <style>
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; opacity: 0; }
        
        @keyframes scale-in {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-scale-in { animation: scale-in 0.6s ease-out forwards; opacity: 0; }
    </style>
</body>
</html>