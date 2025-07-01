<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Tampilan untuk Admin --}}
                    @if (Auth::user()->isAdmin())                        
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                            <!-- Card Jumlah Siswa -->
                            <div class="p-6 text-white bg-blue-500 rounded-lg shadow-md">
                                <h3 class="text-lg">Total Siswa</h3>
                                <p class="text-3xl font-bold">{{ $studentsCount }}</p>
                            </div>
                            <!-- Card Jumlah Materi -->
                            <div class="p-6 text-white bg-green-500 rounded-lg shadow-md">
                                <h3 class="text-lg">Total Materi</h3>
                                <p class="text-3xl font-bold">{{ $materialsCount }}</p>
                            </div>
                            <!-- Card Jumlah Genre -->
                            <div class="p-6 text-white bg-yellow-500 rounded-lg shadow-md">
                                <h3 class="text-lg">Total Genre</h3>
                                <p class="text-3xl font-bold">{{ $genresCount }}</p>
                            </div>
                            <!-- Card Jumlah Chapter -->
                            <div class="p-6 text-white bg-indigo-500 rounded-lg shadow-md">
                                <h3 class="text-lg">Total Chapter</h3>
                                <p class="text-3xl font-bold">{{ $chaptersCount }}</p>
                            </div>
                        </div>

                        {{-- Bagian Aksi Cepat Manajemen Siswa --}}
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900">Manajemen Siswa</h3>
                            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">
        <a href="{{ route('admin.students.create') }}" class="flex flex-col justify-center items-center p-6 text-center bg-white rounded-lg border shadow-sm hover:bg-gray-50">
            <p class="text-xl font-semibold text-indigo-600">Tambah Siswa Baru</p>
            <p class="mt-1 text-sm text-gray-500">Menambahkan satu akun siswa secara manual.</p>
        </a>
        
        <a href="{{ route('admin.students.generate') }}" class="flex flex-col justify-center items-center p-6 text-center bg-white rounded-lg border shadow-sm hover:bg-gray-50">
            <p class="text-xl font-semibold text-teal-600">Generator Siswa Massal</p>
            <p class="mt-1 text-sm text-gray-500">Membuat banyak akun siswa secara otomatis.</p>
        </a>

        <a href="{{ route('admin.students.import.form') }}" class="flex flex-col justify-center items-center p-6 text-center bg-white rounded-lg border shadow-sm hover:bg-gray-50">
            <p class="text-xl font-semibold text-green-600">Import & Generate Akun</p>
            <p class="mt-1 text-sm text-gray-500">Menambahkan banyak siswa dari file spreadsheet.</p>
        </a>
    </div>
                        </div>
                        
                        {{-- Bagian Aksi Cepat Manajemen Materi --}}
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900">Manajemen Materi</h3>
                            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                                <!-- Tombol Tambah Materi Baru -->
                                <a href="{{ route('admin.materials.create') }}" class="flex flex-col justify-center items-center p-6 text-center bg-white rounded-lg border shadow-sm hover:bg-gray-50">
                                    <p class="text-xl font-semibold text-purple-600">Tambah Materi Baru</p>
                                    <p class="mt-1 text-sm text-gray-500">Membuat materi bacaan baru untuk siswa.</p>
                                </a>
                                <!-- Tombol Lihat Semua Materi -->
                                <a href="{{ route('admin.materials.index') }}" class="flex flex-col justify-center items-center p-6 text-center bg-white rounded-lg border shadow-sm hover:bg-gray-50">
                                    <p class="text-xl font-semibold text-cyan-600">Lihat Semua Materi</p>
                                    <p class="mt-1 text-sm text-gray-500">Melihat dan mengelola semua materi yang ada.</p>
                                </a>
                            </div>
                        </div>

                        {{-- Daftar Siswa Terbaru --}}
                        <div class="mt-8">
                            <h3 class="mb-4 text-lg font-semibold">Siswa Terbaru</h3>
                            <ul class="divide-y divide-gray-200">
                                @forelse($latestStudents as $student)
                                    <li class="py-3">{{ $student->name }} - <span class="text-sm text-gray-500">{{ $student->email }}</span></li>
                                @empty
                                    <li class="py-3 text-gray-500">Tidak ada data siswa baru.</li>
                                @endforelse
                            </ul>
                        </div>
                    {{-- Tampilan untuk Siswa --}}
                    @else
                        {{-- 1. Bagian Statistik Progres --}}
                        <div class="mb-8">
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
                        <div class="p-6 mb-6 bg-gray-50 rounded-lg">
                            <form action="{{ route('dashboard') }}" method="GET">
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
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
                                    // Kalkulasi progres materi secara efisien menggunakan data dari controller
                                    $totalActivitiesInMaterial = $material->activities->count();
                                    $answeredActivitiesInMaterial = $material->activities
                                        ->whereIn('id', $userAnsweredActivityIds)
                                        ->count();
                                    $progress = ($totalActivitiesInMaterial > 0) ? round(($answeredActivitiesInMaterial / $totalActivitiesInMaterial) * 100) : 0;
                                @endphp
                                <div class="flex overflow-hidden flex-col justify-between bg-white rounded-lg shadow-md transition hover:shadow-xl">
                                    <div class="p-6">
                                        <h4 class="mb-2 text-lg font-bold">{{ $material->title }}</h4>
                                        <p class="mb-1 text-xs text-gray-500">
                                            Bab: {{ $material->chapter->title ?? 'N/A' }} | Genre: {{ $material->chapter->genre->name ?? 'N/A' }}
                                        </p>
                                        <p class="mb-4 h-20 text-sm text-gray-600">{{ Str::limit($material->description, 120) }}</p>

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
                                             <p class="text-sm italic text-gray-500">Belum ada aktivitas untuk materi ini.</p>
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
        </div>
    </div>
</x-app-layout>
