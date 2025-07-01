<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Tambah Aktivitas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Dropdown untuk memilih materi --}}
                        <div class="mb-4">
                            <label for="reading_material_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Materi Bacaan</label>
                            <select name="reading_material_id" id="reading_material_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                                <option value="">-- Pilih Materi --</option>
                                @foreach ($materials as $material)
                                    {{-- Cek apakah ada material_id dari query URL untuk pre-select --}}
                                    <option value="{{ $material->id }}" {{ request()->query('material_id') == $material->id ? 'selected' : '' }}>
                                        {{ $material->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('reading_material_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Tipe Aktivitas --}}
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Aktivitas</label>
                            <select name="type" id="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                                <option value="multiple_choice">Pilihan Ganda</option>
                                <option value="essay">Esai</option>
                                <option value="true_false">Benar/Salah</option>
                                <option value="fill_in_blank">Isian Singkat</option>
                                <option value="image_based">Berbasis Gambar</option>
                            </select>
                        </div>
                        
                        {{-- Pertanyaan --}}
                        <div class="mb-4">
                            <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pertanyaan</label>
                            <textarea name="question" id="question" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>{{ old('question') }}</textarea>
                        </div>

                        {{-- Opsi Jawaban (untuk pilihan ganda) --}}
                        <div class="mb-4">
                             <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opsi Jawaban (jika Pilihan Ganda)</label>
                             <input type="text" name="options[]" placeholder="Opsi A" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                             <input type="text" name="options[]" placeholder="Opsi B" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                             <input type="text" name="options[]" placeholder="Opsi C" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                             <input type="text" name="options[]" placeholder="Opsi D" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>

                        {{-- Jawaban Benar --}}
                        <div class="mb-4">
                            <label for="correct_answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jawaban Benar</label>
                            <input type="text" name="correct_answer" id="correct_answer" placeholder="Contoh: A, atau 'Benar', atau jawaban esai" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>

                        {{-- Unggah Gambar --}}
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar (Opsional)</label>
                            <input type="file" name="image" id="image" class="block mt-1 w-full text-gray-500">
                        </div>

                        <div class="flex justify-end items-center mt-4">
                            <a href="{{ url()->previous() }}" class="mr-4 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                Simpan Aktivitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
