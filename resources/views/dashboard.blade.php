<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Total Materi</h3>
                        <p class="text-4xl font-bold mt-2">{{ $materialCount }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Total Bab</h3>
                        <p class="text-4xl font-bold mt-2">{{ $chapterCount }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Total Genre</h3>
                        <p class="text-4xl font-bold mt-2">{{ $genreCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Menu Manajemen</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('admin.materials.index') }}" class="block p-6 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <h4 class="font-semibold">Kelola Materi</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Tambah, edit, atau hapus materi bacaan.</p>
                        </a>
                        <a href="{{ route('admin.chapters.index') }}" class="block p-6 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <h4 class="font-semibold">Kelola Bab</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Atur daftar bab dari buku.</p>
                        </a>
                        <a href="{{ route('admin.genres.index') }}" class="block p-6 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <h4 class="font-semibold">Kelola Genre</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Atur kategori genre teks.</p>
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>