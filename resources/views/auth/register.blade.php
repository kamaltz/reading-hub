<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 25s infinite linear;
        }
        
        .shape:nth-child(1) {
            width: 120px;
            height: 120px;
            background: #ffffff;
            border-radius: 50%;
            top: 20%;
            left: 15%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 80px;
            height: 80px;
            background: #ffffff;
            border-radius: 20%;
            top: 60%;
            left: 70%;
            animation-delay: 8s;
        }
        
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            background: #ffffff;
            transform: rotate(45deg);
            top: 30%;
            left: 80%;
            animation-delay: 15s;
        }
        
        .shape:nth-child(4) {
            width: 100px;
            height: 100px;
            background: #ffffff;
            border-radius: 30%;
            top: 80%;
            left: 20%;
            animation-delay: 20s;
        }
        
        .shape:nth-child(5) {
            width: 40px;
            height: 40px;
            background: #ffffff;
            border-radius: 50%;
            top: 10%;
            left: 50%;
            animation-delay: 12s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            33% {
                transform: translateY(-30px) rotate(120deg);
            }
            66% {
                transform: translateY(-15px) rotate(240deg);
            }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .modern-input {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .modern-input:focus {
            background: rgba(255, 255, 255, 1);
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }
        
        .modern-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="relative z-10 w-full max-w-md">
        <div class="glass-card rounded-2xl p-8 shadow-2xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Create Account</h1>
                <p class="text-white/80 text-sm">Join us today</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label for="name" class="block text-white text-sm font-medium">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                           class="modern-input w-full px-4 py-3 rounded-lg focus:outline-none text-gray-800 placeholder-gray-500" 
                           placeholder="Enter your full name">
                    @error('name')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label for="email" class="block text-white text-sm font-medium">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                           class="modern-input w-full px-4 py-3 rounded-lg focus:outline-none text-gray-800 placeholder-gray-500" 
                           placeholder="Enter your email">
                    @error('email')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label for="password" class="block text-white text-sm font-medium">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="modern-input w-full px-4 py-3 rounded-lg focus:outline-none text-gray-800 placeholder-gray-500" 
                           placeholder="Create a password">
                    @error('password')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-white text-sm font-medium">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="modern-input w-full px-4 py-3 rounded-lg focus:outline-none text-gray-800 placeholder-gray-500" 
                           placeholder="Confirm your password">
                    @error('password_confirmation')
                        <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="modern-btn w-full py-3 px-6 rounded-lg font-semibold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Account
                </button>
                
                <div class="text-center">
                    <p class="text-white/80 text-sm">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-white font-semibold hover:underline">
                            Sign in
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.modern-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('pulse');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('pulse');
                });
            });
        });
    </script>
</body>
</html>
