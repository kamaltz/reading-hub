<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Tambah Aktivitas HOTS untuk: <span class="italic font-normal">{{ $material->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- x-data mendefinisikan state awal untuk Alpine.js. 'type' diatur ke 'essay' secara default. --}}
                    {{-- PERBAIKAN: Mengubah action ke rute yang benar dan menambahkan input tersembunyi untuk material_id --}}
                    <form x-data="{ type: '{{ old('type', 'essay') }}' }" action="{{ route('admin.activities.store') }}" method="POST">
                        @csrf
                        {{-- Input tersembunyi untuk mengirimkan ID materi bacaan --}}
                        <input type="hidden" name="reading_material_id" value="{{ $material->id }}">
                        
                        <div class="mb-4">
                            <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                            <textarea name="question" id="question" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('question') }}</textarea>
                            @error('question') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipe Pertanyaan</label>
                            {{-- x-model="type" akan mengikat nilai dropdown ini ke state 'type' di Alpine.js --}}
                            <select name="type" id="type" x-model="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="essay">Essay</option>
                                <option value="multiple_choice">Pilihan Ganda</option>
                            </select>
                        </div>

                        {{-- x-show akan menampilkan/menyembunyikan blok ini berdasarkan nilai dari state 'type' --}}
                        <div x-show="type === 'multiple_choice'" x-transition class="p-4 mt-4 space-y-4 rounded-md border border-gray-200">
                            <h4 class="font-semibold text-gray-800">Opsi Pilihan Ganda</h4>
                            
                            {{-- Input untuk Opsi Jawaban --}}
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label for="options_a" class="block text-sm font-medium text-gray-700">Opsi A</label>
                                    <input type="text" name="options[A]" id="options_a" value="{{ old('options.A') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label for="options_b" class="block text-sm font-medium text-gray-700">Opsi B</label>
                                    <input type="text" name="options[B]" id="options_b" value="{{ old('options.B') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label for="options_c" class="block text-sm font-medium text-gray-700">Opsi C</label>
                                    <input type="text" name="options[C]" id="options_c" value="{{ old('options.C') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label for="options_d" class="block text-sm font-medium text-gray-700">Opsi D</label>
                                    <input type="text" name="options[D]" id="options_d" value="{{ old('options.D') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>
                            @error('options') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror

                            {{-- Dropdown untuk Kunci Jawaban --}}
                            <div class="mt-4">
                                {{-- PERBAIKAN: Mengubah nama input dari 'answer_key' menjadi 'correct_answer' agar sesuai dengan controller --}}
                                <label for="correct_answer" class="block text-sm font-medium text-gray-700">Kunci Jawaban</label>
                                <select name="correct_answer" id="correct_answer" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Kunci Jawaban</option>
                                    <option value="A" @selected(old('correct_answer') == 'A')>A</option>
                                    <option value="B" @selected(old('correct_answer') == 'B')>B</option>
                                    <option value="C" @selected(old('correct_answer') == 'C')>C</option>
                                    <option value="D" @selected(old('correct_answer') == 'D')>D</option>
                                </select>
                                @error('correct_answer') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent ring-gray-300 transition duration-150 ease-in-out hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                                Simpan Aktivitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>