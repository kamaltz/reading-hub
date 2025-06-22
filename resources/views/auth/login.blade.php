<x-guest-layout>
    <div class="min-h-screen flex bg-gray-100 dark:bg-gray-900">
        <div class="hidden lg:flex w-1/2 items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?q=80&w=2128&auto=format&fit=crop');">
            <div class="bg-black/50 p-12 rounded-xl text-white text-center backdrop-blur-sm">
                <a href="/" class="flex justify-center mb-4">
                     <x-application-logo class="w-16 h-16 fill-current text-white" />
                </a>
                <h1 class="text-3xl font-bold">Welcome Back to ReadingHub</h1>
                <p class="mt-2 opacity-80">Your journey to knowledge continues here.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                 <div class="lg:hidden text-center mb-8">
                     <a href="/" class="inline-block">
                        <x-application-logo class="w-16 h-16 fill-current text-gray-500" />
                     </a>
                 </div>
                
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Sign In</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Enter your credentials to access your account.</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex justify-between items-baseline">
                             <x-input-label for="password" :value="__('Password')" />
                             @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div>
                        <x-primary-button class="w-full justify-center">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-500 mt-6">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Sign up
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>