<x-app-layout>
    <div class="flex h-screen bg-gray-900 text-gray-200">
        <aside class="w-64 flex-shrink-0 flex flex-col border-r border-gray-800">
    <div class="h-20 flex items-center justify-center border-b border-gray-800">
        <a href="{{ route('dashboard') }}" class="text-3xl font-bold text-white">
            Reading<span class="text-indigo-400">Hub</span>
        </a>
    </div>
    <nav class="flex-grow p-4 space-y-2">
        {{-- Link ke Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-4 py-2 rounded-lg transition-colors
                  {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg class="h-6 w-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1V10a1 1 0 00-1-1H7a1 1 0 00-1 1v10a1 1 0 001 1h2z"/></svg>
            <span>Dashboard</span>
        </a>

        {{-- Link ke Materials (Contoh: mengarah ke halaman index materi admin) --}}
        <a href="{{ route('admin.materials.index') }}"
           class="flex items-center px-4 py-2 rounded-lg transition-colors
                  {{ request()->routeIs('admin.materials.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg class="h-6 w-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"/></svg>
            <span>My Materials</span>
        </a>

        {{-- Link ke Profile --}}
        <a href="{{ route('profile.edit') }}"
           class="flex items-center px-4 py-2 rounded-lg transition-colors
                  {{ request()->routeIs('profile.edit') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg class="h-6 w-6 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>Profile</span>
        </a>
    </nav>
    <div class="p-4 border-t border-gray-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="flex items-center w-full px-4 py-2 text-gray-400 hover:bg-red-900/50 hover:text-white rounded-lg transition-colors">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Log Out</span>
            </a>
        </form>
    </div>
</aside>

        <main class="flex-1 overflow-y-auto">
            <div class="px-6 py-8">
                <div class="flex justify-between items-center">
                    <h2 class="text-3xl font-bold text-white">Dashboard</h2>
                    <div class="flex items-center">
                        <div class="relative">
                           <button class="flex items-center focus:outline-none">
                                <span class="text-white mr-2">{{ Auth::user()->name }}</span>
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                           </button>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 p-6 bg-gray-800/50 border border-gray-700/50 rounded-xl">
                    <h3 class="text-2xl font-bold text-white">Welcome back, {{ Auth::user()->name }}!</h3>
                    <p class="mt-2 text-gray-400">Ready to expand your knowledge? Let's dive into some new materials.</p>
                </div>
                
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl p-6 flex items-center space-x-4 transform transition-transform hover:-translate-y-1">
                        <div class="p-3 bg-indigo-500/20 rounded-lg"><svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path></svg></div>
                        <div>
                            <p class="text-sm font-medium text-gray-400">Materials Read</p>
                            <p class="text-2xl font-bold text-white">12</p>
                        </div>
                    </div>
                    <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl p-6 flex items-center space-x-4 transform transition-transform hover:-translate-y-1">
                        <div class="p-3 bg-purple-500/20 rounded-lg"><svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <div>
                            <p class="text-sm font-medium text-gray-400">Quizzes Completed</p>
                            <p class="text-2xl font-bold text-white">5</p>
                        </div>
                    </div>
                    <div class="bg-gray-800/50 border border-gray-700/50 rounded-xl p-6 flex items-center space-x-4 transform transition-transform hover:-translate-y-1">
                         <div class="p-3 bg-green-500/20 rounded-lg"><svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.28 9.097c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg></div>
                        <div>
                            <p class="text-sm font-medium text-gray-400">Average Score</p>
                            <p class="text-2xl font-bold text-white">85%</p>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</x-app-layout>