<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Tambah Aktivitas Baru untuk Materi: {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- 
                        PERBAIKAN FINAL: 
                        Menggunakan helper url() untuk menunjuk langsung ke path
                        tanpa bergantung pada cache nama rute.
                    --}}
                    <form action="{{ url('/admin/activities') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="reading_material_id" value="{{ $material->id }}">

                        <div class="mb-4">
                            <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                            <textarea name="question" id="question" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>{{ old('question') }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="correct_answer" class="block text-sm font-medium text-gray-700">Kunci Jawaban</label>
                            <input type="text" name="correct_answer" id="correct_answer" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" value="{{ old('correct_answer') }}" required>
                        </div>


                        <div class="flex justify-end items-center mt-4">
                            <a href="{{ route('admin.materials.show', $material->id) }}" class="px-4 py-2 mr-2 font-bold text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                Simpan Aktivitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
