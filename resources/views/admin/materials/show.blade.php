<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('admin.materials.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            &larr; Kembali ke Daftar Materi
                        </a>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">{{ $material->title }}</h3>
                        <p class="mt-1 text-gray-600">{{ $material->description }}</p>
                    </div>

                    <h4 class="mt-6 mb-2 font-semibold text-md">Aktivitas Terkait</h4>
                    
                    {{-- PERBAIKAN: Mengganti nama rute menjadi 'admin.activities.create' --}}
                    <a href="{{ route('admin.activities.create', $material->id) }}" class="inline-block px-4 py-2 font-bold text-white bg-blue-500 rounded-md hover:bg-blue-700">
                        Tambah Aktivitas Baru
                    </a>

                    <div class="mt-4">
                        <ul class="list-disc list-inside">
                            @forelse ($material->activities as $activity)
                                <li class="py-2">{{ $activity->question }}</li>
                            @empty
                                <li class="py-2 text-gray-500">Belum ada aktivitas untuk materi ini.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>