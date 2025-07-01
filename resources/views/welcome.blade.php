<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reading Hub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            color: #1a202c;
            overflow-x: hidden;
            cursor: none;
        }
        
        .rocket-cursor {
            position: fixed;
            width: 30px;
            height: 30px;
            pointer-events: none;
            z-index: 9999;
            transform: translate(-50%, -50%);
            transition: transform 0.1s ease;
        }
        
        .cursor-trail {
            position: fixed;
            width: 6px;
            height: 6px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9998;
            opacity: 0.8;
        }
        
        .game-container {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            min-width: 250px;
        }
        
        .game-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            z-index: 1001;
            transition: all 0.3s ease;
        }
        
        .game-toggle:hover {
            transform: scale(1.1);
        }
        
        .snake-game {
            border: 2px solid #667eea;
            border-radius: 10px;
            background: #f8f9ff;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
        }
        
        .feature-enhanced {
            position: relative;
            overflow: hidden;
        }
        
        .feature-enhanced::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }
        
        .feature-enhanced:hover::before {
            opacity: 1;
            animation: shimmer 1.5s ease-in-out;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .floating-cta {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .testimonial-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 30px;
            margin: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.6s ease;
        }
        
        .testimonial-card.visible {
            transform: translateY(0);
            opacity: 1;
        }
        #background-canvas, #interactive-canvas {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2;
        }
        #interactive-canvas { z-index: 1000; pointer-events: none; }
        .gradient-text {
            background: linear-gradient(90deg, #4f46e5, #818cf8, #d946ef);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            animation: text-shine 5s linear infinite; background-size: 200% auto;
        }
        @keyframes text-shine { to { background-position: 200% center; } }
        .content-wrapper { position: relative; z-index: 2; }
        .glass-card {
            background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-style: preserve-3d;
        }
        .glass-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 50px 0 rgba(31, 38, 135, 0.2);
        }
        .animated-svg-path {
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: draw 4s ease-in-out forwards infinite alternate;
        }
        @keyframes draw { to { stroke-dashoffset: 0; } }
        #hero-object-container {
            width: 100%; height: 500px;
            display: flex; align-items: center; justify-content: center;
        }
        .parallax-layer { will-change: transform; }
    </style>
</head>
<body class="antialiased">
    <canvas id="background-canvas"></canvas>
    <canvas id="interactive-canvas"></canvas>
    
    <!-- Rocket Cursor -->
    <div class="rocket-cursor">🚀</div>
    
    
    <!-- Game Container -->
    <div class="game-container" id="gameContainer" style="display: none;">
        <h3 class="mb-4 text-lg font-bold text-center">Snake Game</h3>
        <canvas class="snake-game" id="snakeGame" width="200" height="200"></canvas>
        <div class="mt-4 text-center">
            <div class="text-sm">Score: <span id="score">0</span></div>
            <button onclick="startGame()" class="px-4 py-2 mt-2 text-sm text-white bg-indigo-600 rounded-lg">Start Game</button>
        </div>
        <div class="mt-2 text-xs text-center text-gray-600">Use arrow keys to play</div>
    </div>

    <div class="content-wrapper">
        <header class="fixed inset-x-0 top-0 z-50">
            <nav class="flex justify-between items-center p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="#" class="text-xl font-bold tracking-widest gradient-text">R-HUB</a>
                </div>
                <div class="flex items-center space-x-6 lg:flex-1 lg:justify-end">
                     @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold leading-6 text-gray-800 transition hover:text-gray-900">Dashboard &rarr;</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-800 transition hover:text-gray-900">Log in</a>
                        <a href="{{ route('register') }}" class="px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-full shadow-lg transition transform hover:bg-indigo-500 hover:scale-105">Daftar</a>
                    @endauth
                </div>
            </nav>
        </header>

        <!-- Section 1: Hero -->
        <section id="hero" class="flex overflow-hidden relative justify-center items-center min-h-screen">
             <div class="grid gap-8 items-center px-6 mx-auto max-w-7xl lg:grid-cols-2">
                <div class="z-10 text-center lg:text-left parallax-layer" data-speed="0.5">
                    <h1 class="text-4xl font-extrabold tracking-tight sm:text-7xl hero-element">
                        Tingkatkan <span class="gradient-text">Pemahaman Membaca</span>
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600 hero-element">
                        Platform pembelajaran yang dirancang untuk mempertajam analisis teks dan keterampilan berpikir tingkat tinggi (HOTS) melalui pendekatan berbasis genre.
                    </p>
                </div>
                <div class="z-0 parallax-layer" data-speed="-0.2">
                     <div id="hero-object-container"></div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 bg-gradient-to-r from-indigo-600 to-purple-600">
            <div class="px-6 mx-auto max-w-7xl">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                    <div class="stats-card">
                        <div class="text-3xl font-bold">50+</div>
                        <div class="text-sm opacity-90">Siswa Aktif</div>
                    </div>
                    <div class="stats-card">
                        <div class="text-3xl font-bold">20+</div>
                        <div class="text-sm opacity-90">Materi Pembelajaran</div>
                    </div>
                    <div class="stats-card">
                        <div class="text-3xl font-bold">95%</div>
                        <div class="text-sm opacity-90">Tingkat Kepuasan</div>
                    </div>
                    <div class="stats-card">
                        <div class="text-3xl font-bold">24/7</div>
                        <div class="text-sm opacity-90">Akses Pembelajaran</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 2: Features -->
        <section id="features" class="py-24 sm:py-32">
            <div class="px-6 mx-auto max-w-7xl lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl section-title">Ekosistem Belajar yang Terstruktur</h2>
                    <p class="mt-4 text-lg text-gray-600">Platform pembelajaran yang dirancang khusus untuk meningkatkan kemampuan literasi dan berpikir kritis</p>
                </div>
                <div class="grid grid-cols-1 gap-8 mt-16 md:grid-cols-3">
                    @php
                        $features = [
                            ['title' => 'Pendekatan Berbasis Genre', 'description' => 'Pelajari beragam jenis teks—dari naratif hingga eksposisi—dengan struktur otentik dan fitur kebahasaan yang relevan.', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 100 12h-3a7.5 7.5 0 000-12h3zM10.5 9a2.25 2.25 0 110 4.5 2.25 2.25 0 010-4.5z" />'],
                            ['title' => 'Aktivitas Asah HOTS', 'description' => 'Tingkatkan kemampuan menganalisis, mengevaluasi, dan mencipta melalui tantangan interaktif yang mendorong pemikiran kritis.', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />'],
                            ['title' => 'Ilustrasi & Analitik', 'description' => 'Visual pendukung berkualitas tinggi dan analitik progres membantu memperjelas konsep dan memetakan kekuatan Anda.', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />']
                        ];
                    @endphp
                     @foreach ($features as $feature)
                    <div class="p-8 text-center glass-card interactive-card feature-card feature-enhanced">
                        <div class="flex justify-center items-center h-40">
                             <svg class="w-24 h-24 text-indigo-500 animated-svg-path" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">{!! $feature['svg'] !!}</svg>
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-gray-900">{{ $feature['title'] }}</h3>
                        <p class="mt-2 text-base text-gray-600">{{ $feature['description'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-24 bg-gray-50">
            <div class="px-6 mx-auto max-w-7xl">
                <div class="mb-16 text-center">
                    <h2 class="text-3xl font-bold text-gray-900">Apa Kata Mereka?</h2>
                    <p class="mt-4 text-lg text-gray-600">Testimoni dari pengguna yang telah merasakan manfaatnya</p>
                </div>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="testimonial-card">
                        <div class="flex items-center mb-4">
                            <div class="flex justify-center items-center w-12 h-12 font-bold text-white bg-indigo-500 rounded-full">A</div>
                            <div class="ml-4">
                                <div class="font-semibold">Andi Pratama</div>
                                <div class="text-sm text-gray-600">Siswa SMA</div>
                            </div>
                        </div>
                        <p class="text-gray-700">"Platform ini sangat membantu saya memahami berbagai jenis teks. Soal-soal HOTS-nya menantang dan membuat saya berpikir lebih kritis."</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="flex items-center mb-4">
                            <div class="flex justify-center items-center w-12 h-12 font-bold text-white bg-purple-500 rounded-full">S</div>
                            <div class="ml-4">
                                <div class="font-semibold">Sari Dewi</div>
                                <div class="text-sm text-gray-600">Guru Bahasa Indonesia</div>
                            </div>
                        </div>
                        <p class="text-gray-700">"Sebagai guru, saya terbantu dengan materi-materi yang tersedia. Siswa jadi lebih antusias belajar membaca dan menganalisis teks."</p>
                    </div>
                    <div class="testimonial-card">
                        <div class="flex items-center mb-4">
                            <div class="flex justify-center items-center w-12 h-12 font-bold text-white bg-pink-500 rounded-full">R</div>
                            <div class="ml-4">
                                <div class="font-semibold">Rudi Hermawan</div>
                                <div class="text-sm text-gray-600">Mahasiswa</div>
                            </div>
                        </div>
                        <p class="text-gray-700">"Fitur analitik progresnya sangat membantu saya melihat perkembangan kemampuan membaca. Recommended banget!"</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 3: Final CTA -->
        <section id="cta" class="py-24 sm:py-32">
             <div class="isolate overflow-hidden relative px-6 py-24 mx-auto max-w-4xl text-center glass-card sm:px-16 cta-section">
                <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Siap Menguasai Setiap Teks?
                </h2>
                <p class="mt-4 text-lg text-gray-600">Bergabunglah dengan ribuan siswa yang telah meningkatkan kemampuan literasi mereka</p>
                <div class="flex justify-center items-center mt-10 space-x-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full shadow-lg transition transform floating-cta hover:scale-105">Mulai Belajar Gratis</a>
                    <a href="{{ route('login') }}" class="px-8 py-4 text-lg font-semibold text-indigo-600 rounded-full border-2 border-indigo-600 transition hover:bg-indigo-600 hover:text-white">Masuk Sekarang</a>
                </div>
             </div>
        </section>

        <!-- Footer Section -->
        <footer class="py-12 mt-12 backdrop-blur-lg bg-white/50">
            <div class="px-6 mx-auto max-w-7xl lg:px-8">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-semibold gradient-text">Reading Hub</h3>
                        <p class="mt-4 text-gray-600">Misi kami adalah mendemokratisasi pendidikan berkualitas melalui teknologi yang memberdayakan, selaras dengan prinsip literasi modern.</p>
                    </div>
                    <div>
                         <h3 class="text-sm font-semibold text-gray-900">Jelajahi</h3>
                        <ul class="mt-4 space-y-2">
                            <li><a href="#features" class="text-gray-600 transition hover:text-indigo-600">Fitur Utama</a></li>
                            <li><a href="#" class="text-gray-600 transition hover:text-indigo-600">Metodologi</a></li>
                        </ul>
                    </div>
                     <div>
                        <h3 class="text-sm font-semibold text-gray-900">Tingkatkan Literasi</h3>
                        <p class="mt-4 text-gray-600">Pelajari bermacam teks bahasa inggris untuk meningkatkan literasi bahasa inggrismu.</p>
                        {{-- <form class="flex gap-2 mt-4">
                            <input type="email" placeholder="Email Anda" class="px-3 py-2 w-full rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Kirim</button>
                        </form> --}}
                    </div>
                </div>
                <div class="flex flex-col justify-between items-center pt-8 mt-16 text-xs text-gray-500 border-t border-gray-900/10 sm:flex-row">
                    <p>&copy; {{ date('Y') }} ReadingHub.</p>

                </div>
            </div>
        </footer>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    
    <script type="module">
        document.addEventListener('DOMContentLoaded', () => {
            // --- Satisfying Background Animation ---
            const bgCanvas = document.getElementById('background-canvas');
            const bgCtx = bgCanvas.getContext('2d');
            let width, height; const shapes = [];

            class Shape {
                constructor() {
                    this.x = Math.random() * window.innerWidth;
                    this.y = Math.random() * window.innerHeight;
                    this.vx = Math.random() * 0.4 - 0.2;
                    this.vy = Math.random() * 0.4 - 0.2;
                    this.radius = Math.random() * 50 + 20;
                    this.angle = 0;
                    this.dAngle = Math.random() * 0.02 - 0.01;
                    const hue = Math.random() * 60 + 210; // Blues and Purples
                    this.color = `hsla(${hue}, 90%, 80%, 0.1)`;
                    this.isCircle = Math.random() > 0.5;
                }
                draw() {
                    bgCtx.save();
                    bgCtx.translate(this.x, this.y);
                    bgCtx.rotate(this.angle);
                    bgCtx.fillStyle = this.color;
                    bgCtx.beginPath();
                    if (this.isCircle) {
                        bgCtx.arc(0, 0, this.radius, 0, Math.PI * 2);
                    } else {
                        bgCtx.rect(-this.radius, -this.radius, this.radius * 2, this.radius * 2);
                    }
                    bgCtx.fill();
                    bgCtx.restore();
                }
                update() {
                    this.x += this.vx; this.y += this.vy; this.angle += this.dAngle;
                    if (this.x < -this.radius || this.x > width + this.radius) this.vx *= -1;
                    if (this.y < -this.radius || this.y > height + this.radius) this.vy *= -1;
                    this.draw();
                }
            }
            const resizeBg = () => {
                width = bgCanvas.width = window.innerWidth; height = bgCanvas.height = window.innerHeight;
                if(shapes.length === 0) for(let i=0; i<20; i++) shapes.push(new Shape());
            };
            const animateBg = () => {
                bgCtx.clearRect(0, 0, width, height);
                bgCtx.fillStyle = '#f0f4f8';
                bgCtx.fillRect(0,0,width,height);
                shapes.forEach(s => s.update());
                requestAnimationFrame(animateBg);
            };
            window.addEventListener('resize', resizeBg); resizeBg(); animateBg();
            
            // --- Interactive Canvas (Meteors & Cursor Trail) ---
            const intCanvas = document.getElementById('interactive-canvas');
            const intCtx = intCanvas.getContext('2d');
            let mouse = { x: -100, y: -100 }; let particles = []; let meteors = []; let trails = [];
            const resizeInt = () => { intCanvas.width = window.innerWidth; intCanvas.height = window.innerHeight; };
            window.addEventListener('resize', resizeInt); resizeInt();
            
            // Rocket cursor and trail
            const rocketCursor = document.querySelector('.rocket-cursor');
            window.addEventListener('mousemove', e => { 
                mouse.x = e.clientX; mouse.y = e.clientY;
                rocketCursor.style.left = e.clientX + 'px';
                rocketCursor.style.top = e.clientY + 'px';
                
                // Add trail
                trails.push({ x: e.clientX, y: e.clientY, life: 1 });
                if (trails.length > 20) trails.shift();
            });
            
            class Particle {
                constructor(x, y) {
                    this.x = x; this.y = y; this.size = Math.random() * 3 + 1;
                    this.speedX = Math.random() * 2 - 1; this.speedY = Math.random() * 2 - 1;
                    this.color = `hsla(${Math.random() * 60 + 210}, 100%, 70%, 0.9)`; this.life = 1;
                }
                update() { this.x += this.speedX; this.y += this.speedY; this.life -= 0.04; }
                draw() {
                    intCtx.fillStyle = this.color; intCtx.globalAlpha = this.life;
                    intCtx.beginPath(); intCtx.arc(this.x, this.y, this.size, 0, Math.PI * 2); intCtx.fill();
                }
            }
            class Meteor {
                 constructor() { this.reset(); }
                reset() {
                    this.x = Math.random() * width; this.y = -20;
                    this.len = Math.random() * 80 + 20; this.speed = Math.random() * 15 + 10;
                    this.size = Math.random() * 1.5 + 0.5;
                }
                draw() {
                    intCtx.beginPath(); intCtx.moveTo(this.x, this.y);
                    intCtx.lineTo(this.x, this.y + this.len);
                    intCtx.lineWidth = this.size; intCtx.strokeStyle = `rgba(129, 140, 248, 0.5)`;
                    intCtx.stroke();
                }
                update() { this.y += this.speed; if(this.y > height) {this.reset();} this.draw(); }
            }
            for(let i=0; i<35; i++) meteors.push(new Meteor());
            
            const animateInt = () => {
                intCtx.clearRect(0, 0, width, height);
                
                // Draw cursor trail
                for (let i = trails.length - 1; i >= 0; i--) {
                    const trail = trails[i];
                    intCtx.globalAlpha = trail.life;
                    intCtx.fillStyle = `hsl(${200 + i * 10}, 70%, 60%)`;
                    intCtx.beginPath();
                    intCtx.arc(trail.x, trail.y, 3 * trail.life, 0, Math.PI * 2);
                    intCtx.fill();
                    trail.life -= 0.05;
                    if (trail.life <= 0) trails.splice(i, 1);
                }
                intCtx.globalAlpha = 1;
                
                for(let i=0; i<3; i++) particles.push(new Particle(mouse.x, mouse.y));
                for (let i = particles.length - 1; i >= 0; i--) {
                    particles[i].update(); particles[i].draw();
                    if(particles[i].life <= 0) particles.splice(i, 1);
                }
                meteors.forEach(m => m.update());
                requestAnimationFrame(animateInt);
            };
            animateInt();

            // --- 3D Hero Object ---
            const heroContainer = document.getElementById('hero-object-container');
            if(heroContainer){
                const scene = new THREE.Scene();
                const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
                const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
                renderer.setSize(500, 500);
                heroContainer.appendChild(renderer.domElement);
                camera.position.z = 2.5;

                const group = new THREE.Group();
                scene.add(group);

                const geometry = new THREE.TorusKnotGeometry(0.75, 0.25, 200, 32);
                const material = new THREE.MeshStandardMaterial({
                    color: 0x6366f1, metalness: 0.1, roughness: 0.1,
                });
                const mesh = new THREE.Mesh(geometry, material);
                group.add(mesh);
                
                const wireMat = new THREE.MeshBasicMaterial({ color: 0x1e1b4b, wireframe: true, transparent: true, opacity: 0.1 });
                const wireframe = new THREE.Mesh(geometry, wireMat);
                group.add(wireframe);

                scene.add(new THREE.AmbientLight(0xffffff, 1));
                const pointLight = new THREE.PointLight(0xffffff, 2);
                pointLight.position.set(5, 5, 5);
                scene.add(pointLight);

                const animateHero = (time) => {
                    requestAnimationFrame(animateHero);
                    const t = time * 0.0005;
                    group.rotation.x = Math.sin(t) * 0.5;
                    group.rotation.y = Math.cos(t) * 0.5;
                    mesh.material.emissiveIntensity = Math.abs(Math.sin(time * 0.001)) * 0.5;
                    renderer.render(scene, camera);
                }
                animateHero();
            }

            // --- GSAP Animations ---
            gsap.registerPlugin(ScrollTrigger);
            gsap.from(".hero-element", { y: 50, opacity: 0, duration: 1.2, stagger: 0.2, ease: "expo.out" });
            
            document.querySelectorAll("section").forEach((section) => {
                 gsap.from(section.querySelectorAll(".section-title, .feature-card, .cta-section"), {
                    scrollTrigger: {
                        trigger: section,
                        start: "top 70%",
                        toggleActions: "play none none none"
                    },
                    y: 60,
                    opacity: 0,
                    duration: 1,
                    ease: "power3.out",
                    stagger: 0.2
                });
            });

            gsap.utils.toArray(".parallax-layer").forEach(layer => {
                const speed = layer.dataset.speed;
                gsap.to(layer, {
                    y: (i, target) => -ScrollTrigger.maxScroll(window) * speed,
                    ease: "none",
                    scrollTrigger: {
                        trigger: 'body',
                        start: "top top",
                        end: "bottom top",
                        scrub: 1,
                    }
                });
            });

            document.querySelectorAll('.interactive-card').forEach(card => {
                card.addEventListener('mousemove', e => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;
                    gsap.to(card, { rotationX: -y / 30, rotationY: x / 30, transformPerspective: 1000, ease: "power1.out", duration: 0.8 });
                });
                card.addEventListener('mouseleave', () => {
                    gsap.to(card, { rotationX: 0, rotationY: 0, ease: "power1.out", duration: 1 });
                });
            });
            
            // Testimonial cards animation
            const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.testimonial-card').forEach(card => {
                observer.observe(card);
            });
        });
        
        // Game functionality
        let gameRunning = false;
        let snake = [{ x: 100, y: 100 }];
        let food = { x: 150, y: 150 };
        let direction = { x: 0, y: 0 };
        let score = 0;
        
        function toggleGame() {
            const container = document.getElementById('gameContainer');
            container.style.display = container.style.display === 'none' ? 'block' : 'none';
        }
        
        function startGame() {
            if (gameRunning) return;
            gameRunning = true;
            snake = [{ x: 100, y: 100 }];
            food = { x: 150, y: 150 };
            direction = { x: 0, y: 0 };
            score = 0;
            document.getElementById('score').textContent = score;
            gameLoop();
        }
        
        function gameLoop() {
            if (!gameRunning) return;
            
            const canvas = document.getElementById('snakeGame');
            const ctx = canvas.getContext('2d');
            
            // Move snake
            const head = { x: snake[0].x + direction.x * 10, y: snake[0].y + direction.y * 10 };
            
            // Check collision with walls
            if (head.x < 0 || head.x >= 200 || head.y < 0 || head.y >= 200) {
                gameRunning = false;
                alert('Game Over! Score: ' + score);
                return;
            }
            
            // Check collision with self
            if (snake.some(segment => segment.x === head.x && segment.y === head.y)) {
                gameRunning = false;
                alert('Game Over! Score: ' + score);
                return;
            }
            
            snake.unshift(head);
            
            // Check food collision
            if (head.x === food.x && head.y === food.y) {
                score++;
                document.getElementById('score').textContent = score;
                food = {
                    x: Math.floor(Math.random() * 20) * 10,
                    y: Math.floor(Math.random() * 20) * 10
                };
            } else {
                snake.pop();
            }
            
            // Draw game
            ctx.fillStyle = '#f8f9ff';
            ctx.fillRect(0, 0, 200, 200);
            
            // Draw snake
            ctx.fillStyle = '#667eea';
            snake.forEach(segment => {
                ctx.fillRect(segment.x, segment.y, 10, 10);
            });
            
            // Draw food
            ctx.fillStyle = '#ff6b6b';
            ctx.fillRect(food.x, food.y, 10, 10);
            
            setTimeout(gameLoop, 150);
        }
        
        // Game controls
        document.addEventListener('keydown', (e) => {
            if (!gameRunning) return;
            
            switch(e.key) {
                case 'ArrowUp':
                    if (direction.y === 0) direction = { x: 0, y: -1 };
                    break;
                case 'ArrowDown':
                    if (direction.y === 0) direction = { x: 0, y: 1 };
                    break;
                case 'ArrowLeft':
                    if (direction.x === 0) direction = { x: -1, y: 0 };
                    break;
                case 'ArrowRight':
                    if (direction.x === 0) direction = { x: 1, y: 0 };
                    break;
            }
        });
    </script>
</body>
</html>
