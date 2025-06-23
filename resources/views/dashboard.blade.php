<x-app-layout>
    <div class="px-6 py-8">
        <h2 class="text-3xl font-bold text-white">Dashboard</h2>
        
        <div class="p-6 mt-8 rounded-xl border border-gray-700/50 bg-gray-800/50">
            <h3 class="text-2xl font-bold text-white">Welcome back, {{ Auth::user()->name }}!</h3>
            <p class="mt-2 text-gray-400">Ready to expand your knowledge? Let's dive into some new materials.</p>
        </div>
        
        <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 lg:grid-cols-3">
            <div class="flex items-center p-6 space-x-4 rounded-xl border transition-transform transform border-gray-700/50 bg-gray-800/50 hover:-translate-y-1">
                <div class="p-3 rounded-lg bg-indigo-500/20"><svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path></svg></div>
                <div>
                    <p class="text-sm font-medium text-gray-400">Materials Read</p>
                    <p class="text-2xl font-bold text-white">12</p>
                </div>
            </div>
            <div class="flex items-center p-6 space-x-4 rounded-xl border transition-transform transform border-gray-700/50 bg-gray-800/50 hover:-translate-y-1">
                <div class="p-3 rounded-lg bg-purple-500/20"><svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div>
                    <p class="text-sm font-medium text-gray-400">Quizzes Completed</p>
                    <p class="text-2xl font-bold text-white">5</p>
                </div>
            </div>
            <div class="flex items-center p-6 space-x-4 rounded-xl border transition-transform transform border-gray-700/50 bg-gray-800/50 hover:-translate-y-1">
                 <div class="p-3 rounded-lg bg-green-500/20"><svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.28 9.097c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg></div>
                <div>
                    <p class="text-sm font-medium text-gray-400">Average Score</p>
                    <p class="text-2xl font-bold text-white">85%</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>