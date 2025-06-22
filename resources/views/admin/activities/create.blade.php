<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Aktivitas HOTS untuk: <span class="font-normal italic">{{ $material->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- x-data mendefinisikan state awal untuk Alpine.js. 'type' diatur ke 'essay' secara default. --}}
                    <form x-data="{ type: '{{ old('type', 'essay') }}' }" action="{{ route('admin.materials.activities.store', $material) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="question" class="block font-medium text-sm text-gray-700">Pertanyaan</label>
                            <textarea name="question" id="question" rows="4" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('question') }}</textarea>
                            @error('question') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block font-medium text-sm text-gray-700">Tipe Pertanyaan</label>
                            {{-- x-model="type" akan mengikat nilai dropdown ini ke state 'type' di Alpine.js --}}
                            <select name="type" id="type" x-model="type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="essay">Essay</option>
                                <option value="multiple_choice">Pilihan Ganda</option>
                            </select>
                        </div>

                        {{-- x-show akan menampilkan/menyembunyikan blok ini berdasarkan nilai dari state 'type' --}}
                        <div x-show="type === 'multiple_choice'" x-transition class="p-4 border border-gray-200 rounded-md mt-4 space-y-4">
                            <h4 class="font-semibold text-gray-800">Opsi Pilihan Ganda</h4>
                            
                            {{-- Input untuk Opsi Jawaban --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="options_a" class="block text-sm font-medium text-gray-700">Opsi A</label>
                                    <input type="text" name="options[A]" id="options_a" value="{{ old('options.A') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label for="options_b" class="block text-sm font-medium text-gray-700">Opsi B</label>
                                    <input type="text" name="options[B]" id="options_b" value="{{ old('options.B') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label for="options_c" class="block text-sm font-medium text-gray-700">Opsi C</label>
                                    <input type="text" name="options[C]" id="options_c" value="{{ old('options.C') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label for="options_d" class="block text-sm font-medium text-gray-700">Opsi D</label>
                                    <input type="text" name="options[D]" id="options_d" value="{{ old('options.D') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>
                            @error('options') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror

                            {{-- Dropdown untuk Kunci Jawaban --}}
                            <div class="mt-4">
                                <label for="answer_key" class="block text-sm font-medium text-gray-700">Kunci Jawaban</label>
                                <select name="answer_key" id="answer_key" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Kunci Jawaban</option>
                                    <option value="A" @selected(old('answer_key') == 'A')>A</option>
                                    <option value="B" @selected(old('answer_key') == 'B')>B</option>
                                    <option value="C" @selected(old('answer_key') == 'C')>C</option>
                                    <option value="D" @selected(old('answer_key') == 'D')>D</option>
                                </select>
                                @error('answer_key') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Simpan Aktivitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>