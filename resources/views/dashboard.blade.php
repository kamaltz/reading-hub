<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ Auth::user()->isAdmin() ? 'Dashboard Admin' : 'Dashboard Saya' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (Auth::user()->isAdmin())
                        {{-- Tampilan untuk Admin --}}
                        <h3 class="mb-4 text-lg font-semibold">Statistik Sistem</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                            <div class="p-4 bg-blue-100 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Total Materi Bacaan</p>
                                <p class="text-2xl font-bold">{{ $totalMaterials }}</p>
                            </div>
                            <div class="p-4 bg-green-100 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Total Aktivitas HOTS</p>
                                <p class="text-2xl font-bold">{{ $totalActivities }}</p>
                            </div>
                            <div class="p-4 bg-yellow-100 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Total Siswa Terdaftar</p>
                                <p class="text-2xl font-bold">{{ $totalStudents }}</p>
                            </div>
                            <div class="p-4 bg-purple-100 rounded-lg shadow">
                                <p class="text-sm text-gray-600">Total Jawaban Aktivitas</p>
                                <p class="text-2xl font-bold">{{ $totalAnswers }}</p>
                            </div>
                        </div>
                    @else
                        {{-- Tampilan untuk Siswa --}}
                        <h3 class="mb-4 text-lg font-semibold">Progres Belajar Saya</h3>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>