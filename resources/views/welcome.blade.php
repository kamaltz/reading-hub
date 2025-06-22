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
<body class="font-sans antialiased bg-gray-900 text-gray-300">
    <div id="app" class="overflow-x-hidden">
        <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        x-data="{ scrolled: window.scrollY > 50 }"
        @scroll.window="scrolled = (window.scrollY > 50)"
        :class="{ 'bg-gray-900/80 backdrop-blur-lg shadow-lg': scrolled, 'py-6': !scrolled, 'py-4': scrolled }">
    <nav class="container mx-auto px-6 flex justify-between items-center">
        <a href="#" class="text-3xl font-bold text-white">
            Reading<span class="text-indigo-400">Hub</span>
        </a>
        <div class="hidden md:flex items-center space-x-8">
            <a href="#features" class="hover:text-indigo-400 transition-colors">Features</a>
            <a href="#materials" class="hover:text-indigo-400 transition-colors">Materials</a>
            <a href="#cta" class="hover:text-indigo-400 transition-colors">Join</a>
        </div>
        <div class="flex items-center space-x-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-semibold bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition-transform transform hover:scale-105">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-indigo-400 transition-colors">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-semibold bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition-transform transform hover:scale-105">Get Started</a>
                @endif
            @endauth
        </div>
    </nav>
</header>

        <main>
            <section class="relative h-screen flex items-center justify-center text-center text-white">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1534796636912-3b95b3ab5986?q=80&w=2071&auto=format&fit=crop');"></div>
                <div class="absolute inset-0 bg-black/60"></div>
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute w-96 h-96 bg-indigo-500/20 rounded-full -left-20 -top-20 animate-pulse"></div>
                    <div class="absolute w-96 h-96 bg-purple-500/20 rounded-full -right-20 -bottom-20 animate-pulse delay-500"></div>
                </div>

                <div class="relative z-10 p-6">
                    <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.8);">Unlock the Universe of Knowledge</h1>
                    <p class="mt-4 text-lg md:text-xl max-w-3xl mx-auto opacity-80" style="text-shadow: 1px 1px 5px rgba(0,0,0,0.8);">Dive into curated reading materials designed to elevate your critical thinking.</p>
                    <a href="#materials" class="mt-8 inline-block bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold py-4 px-10 rounded-full hover:from-indigo-600 hover:to-purple-700 transition-all transform hover:scale-110 shadow-2xl">
                        Start Exploring
                    </a>
                </div>
            </section>

            <section id="materials" class="py-24 bg-gray-900">
                 <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                         <h2 class="text-4xl font-bold text-white">Featured Materials</h2>
                         <p class="text-gray-400 mt-2">Handpicked content to kickstart your journey.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse ($materials as $material)
                            <div class="card-container">
                                <a href="{{ route('materials.show', $material) }}" class="card-content block bg-gray-800/50 rounded-xl overflow-hidden border border-gray-700/50 transition-all duration-300 hover:border-indigo-400 hover:shadow-2xl hover:shadow-indigo-500/20 transform hover:-translate-y-2">
                                    <img src="{{ $material->illustration_path ? asset('storage/' . $material->illustration_path) : 'https://placehold.co/600x400/111827/374151?text=ReadingHub' }}" alt="{{ $material->title }}" class="w-full h-56 object-cover">
                                    <div class="p-6">
                                        <span class="bg-indigo-500/20 text-indigo-300 text-xs font-semibold px-3 py-1 rounded-full">{{ $material->genre->name }}</span>
                                        <h3 class="mt-4 text-xl font-bold text-white">{{ $material->title }}</h3>
                                        <p class="mt-2 text-gray-400 text-sm">{{ Str::limit(strip_tags($material->content), 100) }}</p>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-3 text-center">No featured materials yet.</p>
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