<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Detail Progres: {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.students.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Daftar Siswa</a>
            </div>

            {{-- Ringkasan Umum --}}
            <div class="overflow-hidden p-6 mb-8 bg-white shadow-sm sm:rounded-lg">
                <h3 class="mb-4 text-lg font-semibold">Ringkasan Umum</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="p-4 bg-blue-100 rounded-lg shadow">
                        <p class="text-sm text-gray-600">Total Aktivitas Dicoba</p>
                        <p class="text-2xl font-bold">{{ $studentAnswers->count() }}</p>
                    </div>
                    <div class="p-4 bg-green-100 rounded-lg shadow">
                        <p class="text-sm text-gray-600">Total Jawaban Benar</p>
                        <p class="text-2xl font-bold">{{ $studentAnswers->where('is_correct', true)->count() }}</p>
                    </div>
                    <div class="p-4 bg-red-100 rounded-lg shadow">
                        <p class="text-sm text-gray-600">Total Jawaban Salah</p>
                        <p class="text-2xl font-bold">{{ $studentAnswers->where('is_correct', false)->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- Detail per Materi --}}
            <h3 class="mb-4 text-xl font-semibold text-gray-800">Detail Progres per Materi</h3>
            <div class="space-y-6">
                @forelse ($materials as $material)
                    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                        <div class="p-6">
                            <h4 class="mb-4 text-lg font-bold text-gray-900">{{ $material->title }}</h4>
                            @if($material->activities->isNotEmpty())
                                <ul class="space-y-2">
                                    @foreach ($material->activities as $activity)
                                        <li class="flex justify-between items-center p-3 bg-gray-50 rounded-md">
                                            <p class="text-gray-700">{{ $activity->question }}</p>
                                            @php
                                                $answer = $studentAnswers->get($activity->id);
                                            @endphp
                                            @if ($answer)
                                                @if ($answer->is_correct)
                                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">Benar</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full">Salah</span>
                                                @endif
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full">Belum Dikerjakan</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-500">Belum ada aktivitas untuk materi ini.</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Tidak ada materi yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
