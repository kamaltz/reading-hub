<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #background-canvas, #interactive-canvas {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2;
        }
        #interactive-canvas { z-index: 1000; pointer-events: none; }
        .gradient-text {
            background: linear-gradient(90deg, #4f46e5, #818cf8, #d946ef);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">
    <canvas id="background-canvas"></canvas>
    <canvas id="interactive-canvas"></canvas>
    
    <div class="flex flex-col items-center pt-6 min-h-screen sm:justify-center sm:pt-0">
        <div>
            <a href="/" class="text-4xl font-bold tracking-widest gradient-text">
                R-HUB
            </a>
        </div>

        <div class="overflow-hidden px-6 py-8 mt-6 w-full shadow-2xl backdrop-blur-xl sm:max-w-md bg-white/70 sm:rounded-2xl">
            {{ $slot }}
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <!-- Main Animation Script -->
    <script type="module">
        // Salin dan tempel SELURUH skrip JavaScript dari welcome.blade.php Anda ke sini
        // Termasuk: Aurora Background, Interactive Canvas (Meteors & Cursor Trail)
        document.addEventListener('DOMContentLoaded', () => {
            // Aurora Background
            const bgCanvas = document.getElementById('background-canvas');
            const bgCtx = bgCanvas.getContext('2d');
            let width, height; const numPoints = 6; const points = [];
            class Point {
                constructor(index) {
                    this.x = Math.random() * window.innerWidth; this.y = Math.random() * window.innerHeight;
                    this.vx = (Math.random() - 0.5) * 0.7; this.vy = (Math.random() - 0.5) * 0.7;
                    this.radius = Math.random() * 300 + 200;
                    const hue = (360 / numPoints) * index;
                    this.color = `hsla(${hue + 200}, 80%, 75%, 0.15)`;
                }
                update() {
                    this.x += this.vx; this.y += this.vy;
                    if (this.x < 0 || this.x > width) this.vx *= -1;
                    if (this.y < 0 || this.y > height) this.vy *= -1;
                }
            }
            const resizeBg = () => {
                width = bgCanvas.width = window.innerWidth; height = bgCanvas.height = window.innerHeight;
                if(points.length === 0) for(let i=0; i<numPoints; i++) points.push(new Point(i));
            };
            const animateBg = () => {
                bgCtx.clearRect(0, 0, width, height);
                points.forEach(p => {
                    p.update(); bgCtx.beginPath();
                    const gradient = bgCtx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.radius);
                    gradient.addColorStop(0, p.color); gradient.addColorStop(1, `${p.color.slice(0,-5)}0)`);
                    bgCtx.fillStyle = gradient; bgCtx.arc(p.x, p.y, p.radius, 0, Math.PI * 2); bgCtx.fill();
                });
                requestAnimationFrame(animateBg);
            };
            window.addEventListener('resize', resizeBg); resizeBg(); animateBg();

            // Interactive Canvas (Ripples & Meteors)
            const intCanvas = document.getElementById('interactive-canvas');
            const intCtx = intCanvas.getContext('2d');
            let ripples = [], meteors = [];
            const resizeInt = () => { intCanvas.width = window.innerWidth; intCanvas.height = window.innerHeight; };
            window.addEventListener('resize', resizeInt); resizeInt();

            class Ripple {
                 constructor(x,y) { this.x = x; this.y = y; this.radius = 0; this.alpha = 1; }
                draw() {
                    intCtx.beginPath(); intCtx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    intCtx.strokeStyle = `rgba(129, 140, 248, ${this.alpha * 0.5})`; intCtx.lineWidth = 2; intCtx.stroke();
                }
                update() { this.radius += 1.5; this.alpha -= 0.02; this.draw(); }
            }
             class Meteor {
                constructor() { this.reset(); }
                reset() {
                    this.x = Math.random() * width; this.y = -20;
                    this.len = Math.random() * 80 + 10; this.speed = Math.random() * 15 + 8;
                    this.size = Math.random() * 1.2 + 0.2;
                }
                draw() {
                    intCtx.beginPath(); intCtx.moveTo(this.x, this.y);
                    intCtx.lineTo(this.x + this.len / 5, this.y + this.len);
                    intCtx.lineWidth = this.size; intCtx.strokeStyle = `rgba(255, 255, 255, 0.3)`;
                    intCtx.stroke();
                }
                update() { this.y += this.speed; if(this.y > height) {this.reset();} this.draw(); }
            }
            document.addEventListener('click', e => ripples.push(new Ripple(e.clientX, e.clientY)));
            for(let i=0; i<30; i++) meteors.push(new Meteor());
            
            const animateInt = () => {
                intCtx.clearRect(0, 0, width, height);
                ripples.forEach((r, i) => { r.update(); if(r.alpha <= 0) ripples.splice(i, 1); });
                meteors.forEach(m => m.update());
                requestAnimationFrame(animateInt);
            };
            animateInt();

            // Form animation
            gsap.from(".sm\\:max-w-md", {
                duration: 1,
                y: 50,
                opacity: 0,
                ease: 'expo.out'
            });
        });
    </script>
</body>
</html>
