<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Materi: {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.materials.update', $material->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Judul --}}
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title', $material->title) }}" required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $material->description) }}</textarea>
                        </div>

                        {{-- Genre --}}
                         <div class="mb-4">
                            <label for="genre_id" class="block text-sm font-medium text-gray-700">Genre</label>
                            <select name="genre_id" id="genre_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}" {{ $material->genre_id == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Chapter --}}
                        <div class="mb-4">
                            <label for="chapter_id" class="block text-sm font-medium text-gray-700">Bab</label>
                            <select name="chapter_id" id="chapter_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                 @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}" {{ $material->chapter_id == $chapter->id ? 'selected' : '' }}>
                                        {{ $chapter->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end items-center mt-4">
                            <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                Perbarui Materi
                            </button>
                        </div>
                    </form>

                    <hr class="my-6">

                    {{-- Bagian Aktivitas --}}
                    <div>
                        <h4 class="mb-4 font-semibold text-md">Aktivitas Terkait</h4>
                        
                        {{-- PERBAIKAN: Menggunakan nama rute yang benar 'admin.activities.create' --}}
                        <a href="{{ route('admin.activities.create', $material->id) }}" class="inline-block px-4 py-2 mb-4 font-bold text-white bg-green-500 rounded-md hover:bg-green-700">
                            Tambah Aktivitas Baru
                        </a>
                        
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
