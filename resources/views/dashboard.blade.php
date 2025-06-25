<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ Auth::user()->isAdmin() ? 'Dashboard Admin' : 'Dashboard Saya' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (Auth::user()->isAdmin())
                {{-- Tampilan untuk Admin (Tidak Berubah) --}}
                <div class="overflow-hidden p-6 bg-white shadow-sm sm:rounded-lg">
                    {{-- Konten dasbor admin di sini --}}
                    <p>Selamat datang, Admin!</p>
                </div>
            @else
                {{-- TAMPILAN UNTUK SISWA --}}
                {{-- 1. Bagian Statistik Progres --}}
                <div class="overflow-hidden p-6 mb-8 bg-white shadow-sm sm:rounded-lg">
                    <h3 class="mb-4 text-lg font-semibold">Progres Belajar Saya</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="p-4 bg-green-100 rounded-lg shadow">
                            <p class="text-sm text-gray-600">Aktivitas yang Dicoba</p>
                            <p class="text-2xl font-bold">{{ $totalAttemptedActivities }}</p>
                        </div>
                        <div class="p-4 bg-blue-100 rounded-lg shadow">
                            <p class="text-sm text-gray-600">Jawaban Benar</p>
                            <p class="text-2xl font-bold">{{ $completedActivities }}</p>
                        </div>
                        <div class="p-4 bg-yellow-100 rounded-lg shadow">
                            <p class="text-sm text-gray-600">Total Aktivitas Tersedia</p>
                            <p class="text-2xl font-bold">{{ $totalAvailableActivities }}</p>
                        </div>
                    </div>
                </div>

                {{-- 2. Bagian Filter Materi --}}
                <div class="p-6 mb-6 bg-white rounded-lg shadow-sm">
                    <form action="{{ route('dashboard') }}" method="GET">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                            <div>
                                <label for="chapter_id" class="block text-sm font-medium text-gray-700">Filter berdasarkan Bab</label>
                                <select name="chapter_id" id="chapter_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua Bab</option>
                                    @foreach ($chapters as $chapter)
                                        <option value="{{ $chapter->id }}" {{ request('chapter_id') == $chapter->id ? 'selected' : '' }}>
                                            {{ $chapter->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="genre_id" class="block text-sm font-medium text-gray-700">Filter berdasarkan Genre</label>
                                <select name="genre_id" id="genre_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua Genre</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                                            {{ $genre->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end space-x-2">
                                <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md border border-transparent shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Filter
                                </button>
                                <a href="{{ route('dashboard') }}" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- 3. Bagian Daftar Materi Pembelajaran --}}
                <h3 class="mb-4 text-xl font-semibold text-gray-800">Materi Pembelajaran</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($materials as $material)
                        @php
                            // PERBAIKAN 1: Menggunakan nama relasi 'activities'
                            $totalActivitiesInMaterial = $material->activities->count();
                            
                            // PERBAIKAN 2: Menggunakan nama relasi 'answers'
                            $answeredActivitiesInMaterial = Auth::user()->answers()
                                ->whereIn('hots_activity_id', $material->activities->pluck('id'))
                                ->distinct('hots_activity_id')
                                ->count();
                            $progress = ($totalActivitiesInMaterial > 0) ? ($answeredActivitiesInMaterial / $totalActivitiesInMaterial) * 100 : 0;
                        @endphp
                        <div class="flex overflow-hidden flex-col justify-between bg-white rounded-lg shadow-md">
                            <div class="p-6">
                                <h4 class="mb-2 text-lg font-bold">{{ $material->title }}</h4>
                                <p class="mb-4 text-sm text-gray-600">{{ Str::limit($material->description, 100) }}</p>

                                @if ($totalActivitiesInMaterial > 0)
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">Progres</span>
                                            <span class="text-sm font-medium text-gray-700">{{ $answeredActivitiesInMaterial }} / {{ $totalActivitiesInMaterial }} Aktivitas</span>
                                        </div>
                                        <div class="w-full h-2.5 bg-gray-200 rounded-full">
                                            <div class="h-2.5 bg-blue-600 rounded-full" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                @else
                                     <p class="text-sm text-gray-500">Belum ada aktivitas untuk materi ini.</p>
                                @endif
                            </div>
                            <div class="px-6 py-4 bg-gray-50">
                                <a href="{{ route('materials.show', $material) }}" class="inline-block px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                    Lihat Materi
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="p-6 text-center text-gray-500 bg-white rounded-lg shadow-md">
                                <p>Tidak ada materi yang ditemukan sesuai dengan filter Anda.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</x-app-layout>