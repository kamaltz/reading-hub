<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Materi Bacaan Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.materials.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">Judul</label>
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="illustration" class="block font-medium text-sm text-gray-700">Ilustrasi (Opsional)</label>
                            <input type="file" name="illustration" id="illustration" class="block mt-1 w-full">
                            @error('illustration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block font-medium text-sm text-gray-700">Konten</label>
                            <textarea name="content" id="content" rows="10" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required></textarea>
                            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="chapter_id" class="block font-medium text-sm text-gray-700">Bab</label>
                            <select name="chapter_id" id="chapter_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                                @endforeach
                            </select>
                            @error('chapter_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="genre_id" class="block font-medium text-sm text-gray-700">Genre</label>
                            <select name="genre_id" id="genre_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                            @error('genre_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Simpan Materi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>