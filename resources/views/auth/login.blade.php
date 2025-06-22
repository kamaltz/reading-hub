<x-guest-layout>
    <div class="relative min-h-screen flex items-center justify-center bg-gray-900 overflow-hidden">
        <div class="absolute w-96 h-96 bg-indigo-500/20 rounded-full -left-20 -top-20 animate-pulse"></div>
        <div class="absolute w-96 h-96 bg-purple-500/20 rounded-full -right-20 -bottom-20 animate-pulse delay-500"></div>

        <div class="relative z-10 w-full max-w-md p-8 space-y-6 bg-gray-800/50 backdrop-blur-md rounded-2xl border border-gray-700/50">
            <div class="text-center">
                <a href="/" class="text-4xl font-bold text-white">
                    Reading<span class="text-indigo-400">Hub</span>
                </a>
                <p class="mt-2 text-gray-400">Welcome back, explorer.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="text-sm font-medium text-gray-300">Email</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="w-full px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                               placeholder="you@example.com" :value="old('email')">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-sm font-medium text-gray-300">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-indigo-400 hover:text-indigo-300">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="w-full px-4 py-3 bg-gray-900/50 border border-gray-700 rounded-lg text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                               class="h-4 w-4 text-indigo-600 bg-gray-700 border-gray-600 rounded focus:ring-indigo-500">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-400">
                            Remember me
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-gray-900 transition-all transform hover:scale-105">
                        Log in
                    </button>
                </div>
            </form>
            
            <p class="text-center text-sm text-gray-400">
                Not a member?
                <a href="{{ route('register') }}" class="font-medium text-indigo-400 hover:text-indigo-300">
                    Sign up
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>