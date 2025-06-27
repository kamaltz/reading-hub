<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Materi Bacaan: {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- # PERBAIKAN: Tambah method('PUT') dan enctype untuk upload file --}}
                    <form method="POST" action="{{ route('admin.materials.update', $material->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Judul -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title', $material->title) }}" required>
                            @error('title') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- # PERBAIKAN: Tampilkan ilustrasi yang sudah ada --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Ilustrasi Saat Ini</label>
                            @if ($material->illustration_path)
                                <img src="{{ asset('storage/' . $material->illustration_path) }}" alt="Ilustrasi" class="mt-2 w-48 h-auto rounded-md shadow">
                            @else
                                <p class="mt-2 text-sm text-gray-500">Tidak ada ilustrasi.</p>
                            @endif
                        </div>

                        {{-- # PERBAIKAN: Tambah input untuk mengganti foto --}}
                        <div class="mb-4">
                            <label for="illustration" class="block text-sm font-medium text-gray-700">Ganti Ilustrasi (Opsional)</label>
                            <input type="file" name="illustration" id="illustration" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengganti ilustrasi.</p>
                            @error('illustration') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Konten -->
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Konten</label>
                            <textarea name="content" id="content" rows="10" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>{{ old('content', $material->content) }}</textarea>
                            @error('content') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bab -->
                        <div class="mb-4">
                            <label for="chapter_id" class="block text-sm font-medium text-gray-700">Bab</label>
                            <select name="chapter_id" id="chapter_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}" @selected(old('chapter_id', $material->chapter_id) == $chapter->id)>
                                        {{ $chapter->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('chapter_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Genre -->
                        <div class="mb-4">
                            <label for="genre_id" class="block text-sm font-medium text-gray-700">Genre</label>
                            <select name="genre_id" id="genre_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}" @selected(old('genre_id', $material->genre_id) == $genre->id)>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genre_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent ring-gray-300 transition duration-150 ease-in-out hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                            Perbarui Materi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
