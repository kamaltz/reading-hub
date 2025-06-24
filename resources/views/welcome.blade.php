<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReadingHub - A Futuristic Learning Journey</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-300 bg-gray-900">
    <div id="app" class="overflow-x-hidden">
        <header class="fixed top-0 right-0 left-0 z-50 transition-all duration-300"
        x-data="{ scrolled: window.scrollY > 50 }"
        @scroll.window="scrolled = (window.scrollY > 50)"
        :class="{ 'bg-gray-900/80 backdrop-blur-lg shadow-lg': scrolled, 'py-6': !scrolled, 'py-4': scrolled }">
    <nav class="container flex justify-between items-center px-6 mx-auto">
        <a href="#" class="text-3xl font-bold text-white">
            Reading<span class="text-indigo-400">Hub</span>
        </a>
        <div class="hidden items-center space-x-8 md:flex">
            <a href="#features" class="transition-colors hover:text-indigo-400">Features</a>
            <a href="#materials" class="transition-colors hover:text-indigo-400">Materials</a>
            <a href="#cta" class="transition-colors hover:text-indigo-400">Join</a>
        </div>
        <div class="flex items-center space-x-4">
            @auth
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('dashboard') }}" class="px-5 py-2 text-sm font-semibold text-white bg-indigo-500 rounded-full transition-transform transform hover:bg-indigo-600 hover:scale-105">Admin Dashboard</a>
                @else
                    <a href="{{ route('dashboard') }}" class="px-5 py-2 text-sm font-semibold text-white bg-indigo-500 rounded-full transition-transform transform hover:bg-indigo-600 hover:scale-105">My Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold transition-colors hover:text-indigo-400">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-semibold text-white bg-indigo-500 rounded-full transition-transform transform hover:bg-indigo-600 hover:scale-105">Register</a>
                @endif
            @endauth
        </div>
    </nav>
</header>

        <main>
            <section class="flex relative justify-center items-center h-screen text-center text-white">
                <div class="absolute inset-0 bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1534796636912-3b95b3ab5986?q=80&w=2071&auto=format&fit=crop');"></div>
                <div class="absolute inset-0 bg-black/60"></div>
                <div class="overflow-hidden absolute inset-0">
                    <div class="absolute -top-20 -left-20 w-96 h-96 rounded-full animate-pulse bg-indigo-500/20"></div>
                    <div class="absolute -right-20 -bottom-20 w-96 h-96 rounded-full delay-500 animate-pulse bg-purple-500/20"></div>
                </div>

                <div class="relative z-10 p-6">
                    <h1 class="text-5xl font-extrabold tracking-tight md:text-7xl" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.8);">Unlock the Universe of Knowledge</h1>
                    <p class="mx-auto mt-4 max-w-3xl text-lg opacity-80 md:text-xl" style="text-shadow: 1px 1px 5px rgba(0,0,0,0.8);">Dive into curated reading materials designed to elevate your critical thinking.</p>
                    <a href="#materials" class="inline-block px-10 py-4 mt-8 font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full shadow-2xl transition-all transform hover:from-indigo-600 hover:to-purple-700 hover:scale-110">
                        Start Exploring
                    </a>
                </div>
            </section>

            <section id="materials" class="py-24 bg-gray-900">
                 <div class="container px-6 mx-auto">
                    <div class="mb-12 text-center">
                         <h2 class="text-4xl font-bold text-white">Featured Materials</h2>
                         <p class="mt-2 text-gray-400">Handpicked content to kickstart your journey.</p>
                    </div>
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                        @forelse ($materials as $material)
                            <div class="card-container">
                                <a href="{{ route('materials.show', $material) }}" class="block overflow-hidden rounded-xl border transition-all duration-300 transform card-content bg-gray-800/50 border-gray-700/50 hover:border-indigo-400 hover:shadow-2xl hover:shadow-indigo-500/20 hover:-translate-y-2">
                                    <img src="{{ $material->illustration_path ? asset('storage/' . $material->illustration_path) : 'https://placehold.co/600x400/111827/374151?text=ReadingHub' }}" alt="{{ $material->title }}" class="object-cover w-full h-56">
                                    <div class="p-6">
                                        <span class="px-3 py-1 text-xs font-semibold text-indigo-300 rounded-full bg-indigo-500/20">{{ $material->genre->name }}</span>
                                        <h3 class="mt-4 text-xl font-bold text-white">{{ $material->title }}</h3>
                                        <p class="mt-2 text-sm text-gray-400">{{ Str::limit(strip_tags($material->content), 100) }}</p>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p class="col-span-3 text-center text-gray-500">No featured materials yet.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('header', () => ({
                scrolled: false,
            }));
        });
    </script>
    <style>
        /* Custom font */
        .font-sans {
            font-family: 'Space Grotesk', sans-serif;
        }

        /* Interactive card effect */
        .card-container {
            perspective: 1000px;
        }
        .card-content {
            transform-style: preserve-3d;
            transition: transform 0.5s;
        }
        .card-container:hover .card-content {
            transform: rotateY(5deg) rotateX(5deg);
        }
    </style>
</body>
</html>