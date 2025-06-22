<x-app-layout>
    {{-- Bagian Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Materi: {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Form ini akan mengirim data ke route 'admin.materials.update' dengan method PUT/PATCH --}}
                    {{-- enctype="multipart/form-data" wajib ada untuk menangani upload file --}}
                    <form action="{{ route('admin.materials.update', $material) }}" method="POST" enctype="multipart/form-data">
                        <div class="mt-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold">Aktivitas HOTS untuk Materi Ini</h3>
                    {{-- Tombol ini akan mengarah ke form 'create' untuk aktivitas --}}
                    <a href="{{ route('admin.materials.activities.create', $material) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                        Tambah Aktivitas Baru
                    </a>
                </div>

                {{-- Daftar Aktivitas yang Sudah Ada --}}
                <div class="mt-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pertanyaan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($material->hotsActivities as $activity)
                                <tr>
                                    <td class="px-6 py-4">{{ Str::limit($activity->question, 50) }}</td>
                                    <td class="px-6 py-4">{{ $activity->type == 'multiple_choice' ? 'Pilihan Ganda' : 'Essay' }}</td>
                                    <td class="px-6 py-4">
                                        {{-- Tombol Edit & Hapus mengarah ke controller aktivitas --}}
                                        <a href="{{ route('admin.activities.edit', $activity) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Yakin ingin menghapus aktivitas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada aktivitas untuk materi ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


                        @csrf
                        @method('PUT') {{-- Memberitahu Laravel bahwa ini adalah request UPDATE --}}

                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">Judul</label>
                            {{-- old('title', $material->title) akan menampilkan input lama jika validasi gagal, jika tidak, tampilkan data asli --}}
                            <input type="text" name="title" id="title" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('title', $material->title) }}" required autofocus>
                            @error('title')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block font-medium text-sm text-gray-700">Konten</label>
                            <textarea name="content" id="content" rows="10" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>{{ old('content', $material->content) }}</textarea>
                            @error('content')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="chapter_id" class="block font-medium text-sm text-gray-700">Bab</label>
                            <select name="chapter_id" id="chapter_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                @foreach ($chapters as $chapter)
                                    {{-- Logika untuk memilih opsi yang sesuai dengan data yang sudah ada --}}
                                    <option value="{{ $chapter->id }}" @if(old('chapter_id', $material->chapter_id) == $chapter->id) selected @endif>
                                        {{ $chapter->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('chapter_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="genre_id" class="block font-medium text-sm text-gray-700">Genre</label>
                            <select name="genre_id" id="genre_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}" @if(old('genre_id', $material->genre_id) == $genre->id) selected @endif>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                             @error('genre_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="illustration" class="block font-medium text-sm text-gray-700">Ganti Ilustrasi (Opsional)</label>
                            {{-- Menampilkan gambar yang ada saat ini jika ada --}}
                            @if ($material->illustration_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $material->illustration_path) }}" alt="Ilustrasi saat ini" class="w-48 h-auto rounded-md">
                                </div>
                            @endif
                            <input type="file" name="illustration" id="illustration" class="block mt-2 w-full">
                             @error('illustration')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="flex items-center">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Perbarui Materi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>