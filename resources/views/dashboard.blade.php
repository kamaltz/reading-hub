<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">Selamat Datang Kembali, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600 dark:text-gray-400">Ini adalah pusat kendali untuk mengelola konten ReadingHub.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg flex items-center space-x-4">
                    <div class="bg-indigo-100 dark:bg-indigo-500/20 p-3 rounded-full">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Materi</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $materialCount }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg flex items-center space-x-4">
                     <div class="bg-green-100 dark:bg-green-500/20 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Bab</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $chapterCount }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg flex items-center space-x-4">
                    <div class="bg-yellow-100 dark:bg-yellow-500/20 p-3 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-5-5A2 2 0 013 8V5a2 2 0 012-2h2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Genre</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $genreCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Aksi Cepat</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.materials.create') }}" class="flex-1 min-w-[200px] text-center bg-indigo-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-indigo-700 transition">
                            + Tambah Materi Baru
                        </a>
                        <a href="{{ route('admin.chapters.create') }}" class="flex-1 min-w-[200px] text-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold py-3 px-4 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            + Tambah Bab Baru
                        </a>
                        <a href="{{ route('admin.genres.create') }}" class="flex-1 min-w-[200px] text-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold py-3 px-4 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            + Tambah Genre Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>