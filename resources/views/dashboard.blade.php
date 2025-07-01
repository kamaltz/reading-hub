<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="text-gray-100">
                    {{-- Tampilan untuk Admin --}}
                    @if (Auth::user()->isAdmin())
                        <!-- Statistics Cards -->
                        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                            <div class="p-6 bg-blue-600 rounded-lg shadow-lg">
                                <div class="flex items-center">
                                    <div class="p-3 bg-blue-800 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-blue-100">Total Siswa</p>
                                        <p class="text-2xl font-bold text-white">{{ $studentsCount }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6 bg-green-600 rounded-lg shadow-lg">
                                <div class="flex items-center">
                                    <div class="p-3 bg-green-800 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-green-100">Total Materi</p>
                                        <p class="text-2xl font-bold text-white">{{ $materialsCount }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6 bg-purple-600 rounded-lg shadow-lg">
                                <div class="flex items-center">
                                    <div class="p-3 bg-purple-800 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-purple-100">Total Aktivitas</p>
                                        <p class="text-2xl font-bold text-white">{{ $activitiesCount }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6 bg-orange-600 rounded-lg shadow-lg">
                                <div class="flex items-center">
                                    <div class="p-3 bg-orange-800 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-orange-100">Rata-rata Skor</p>
                                        <p class="text-2xl font-bold text-white">{{ $averageScore }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Overview -->
                        <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                            <div class="p-6 bg-gray-800 rounded-lg shadow-lg">
                                <h3 class="mb-4 text-lg font-semibold text-white">Progres Keseluruhan</h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-300">Siswa Aktif</span>
                                        <span class="text-white font-semibold">{{ $activeStudents }}/{{ $studentsCount }}</span>
                                    </div>
                                    <div class="w-full bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $studentsCount > 0 ? ($activeStudents / $studentsCount) * 100 : 0 }}%"></div>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-300">Total Jawaban</span>
                                        <span class="text-white font-semibold">{{ $totalAnswers }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-300">Jawaban Benar</span>
                                        <span class="text-green-400 font-semibold">{{ $correctAnswers }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6 bg-gray-800 rounded-lg shadow-lg">
                                <h3 class="mb-4 text-lg font-semibold text-white">Siswa Terbaru</h3>
                                <div class="space-y-3">
                                    @forelse($latestStudents as $student)
                                        <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                                            <div>
                                                <p class="text-white font-medium">{{ $student->name }}</p>
                                                <p class="text-sm text-gray-400">{{ $student->email }}</p>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $student->created_at->diffForHumans() }}</span>
                                        </div>
                                    @empty
                                        <p class="text-gray-400">Belum ada siswa terdaftar.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="p-6 bg-gray-800 rounded-lg shadow-lg">
                            <h3 class="mb-4 text-lg font-semibold text-white">Aktivitas Terbaru</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="border-b border-gray-700">
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-300">Siswa</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-300">Materi</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-300">Status</th>
                                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-300">Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        @forelse($recentAnswers as $answer)
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-white">{{ $answer->user->name }}</td>
                                                <td class="px-4 py-3 text-sm text-gray-300">{{ $answer->hotsActivity->readingMaterial->title ?? 'N/A' }}</td>
                                                <td class="px-4 py-3">
                                                    @if($answer->is_correct)
                                                        <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">Benar</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full">Salah</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-400">{{ $answer->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-3 text-center text-gray-400">Belum ada aktivitas.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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
