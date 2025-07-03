<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Aktivitas untuk: <span class="italic font-normal">{{ $activity->readingMaterial->title ?? 'N/A' }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Inisialisasi Alpine.js dengan data yang ada --}}
                    <form x-data="{
                            type: '{{ old('type', $activity->type) }}',
                            matchingOptions: {{ json_encode(old('options', $activity->type === 'matching' ? $activity->options : [['prompt' => '', 'answer' => '']])) }}
                          }"
                          action="{{ route('admin.activities.update', $activity) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Pertanyaan --}}
                        <div class="mb-4">
                            <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                            <textarea name="question" id="question" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('question', $activity->question) }}</textarea>
                            @error('question') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Gambar --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Gambar Saat Ini</label>
                            @if ($activity->image)
                                <img src="{{ asset('storage/' . $activity->image) }}" alt="Activity Image" class="mt-2 w-48 h-auto rounded-md shadow">
                            @else
                                <p class="mt-2 text-sm text-gray-500">Tidak ada gambar.</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Ganti Gambar (Opsional)</label>
                            <input type="file" name="image" id="image" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengganti gambar.</p>
                            @error('image') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Tipe Pertanyaan --}}
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipe Pertanyaan</label>
                            <select name="type" id="type" x-model="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="essay">Essay</option>
                                <option value="multiple_choice">Pilihan Ganda</option>
                                <option value="true_false">Benar / Salah</option>
                                <option value="matching">Pencocokan</option>
                                <option value="fill_in_blank">Isi Bagian Kosong</option>
                            </select>
                        </div>

                        {{-- OPSI: Pilihan Ganda --}}
                        <div x-show="type === 'multiple_choice'" x-transition class="p-4 mt-4 space-y-4 rounded-md border border-gray-200">
                            <h4 class="font-semibold text-gray-800">Opsi Pilihan Ganda</h4>
                            @php $mcOptions = old('options', $activity->type === 'multiple_choice' ? $activity->options : ['A' => '', 'B' => '', 'C' => '', 'D' => '']); @endphp
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                @foreach(['A', 'B', 'C', 'D'] as $key)
                                <div>
                                    <label for="options_{{ strtolower($key) }}" class="block text-sm font-medium text-gray-700">Opsi {{ $key }}</label>
                                    <input type="text" name="options[{{ $key }}]" id="options_{{ strtolower($key) }}" value="{{ $mcOptions[$key] ?? '' }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                @endforeach
                            </div>
                            @error('options') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                            <div class="mt-4">
                                <label for="correct_answer_mc" class="block text-sm font-medium text-gray-700">Kunci Jawaban</label>
                                <select name="correct_answer" id="correct_answer_mc" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Pilih Kunci Jawaban</option>
                                    @foreach(['A', 'B', 'C', 'D'] as $key)
                                    <option value="{{ $key }}" @selected(old('correct_answer', $activity->correct_answer) == $key)>{{ $key }}</option>
                                    @endforeach
                                </select>
                                @error('correct_answer') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- OPSI: Benar / Salah --}}
                        <div x-show="type === 'true_false'" x-transition class="p-4 mt-4 rounded-md border border-gray-200">
                             <label for="correct_answer_tf" class="block text-sm font-medium text-gray-700">Kunci Jawaban</label>
                             <select name="correct_answer" id="correct_answer_tf" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                 <option value="">Pilih Kunci Jawaban</option>
                                 <option value="true" @selected(old('correct_answer', $activity->correct_answer) == 'true')>Benar</option>
                                 <option value="false" @selected(old('correct_answer', $activity->correct_answer) == 'false')>Salah</option>
                             </select>
                             @error('correct_answer') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- OPSI: Pencocokan --}}
                        <div x-show="type === 'matching'" x-transition class="p-4 mt-4 space-y-4 rounded-md border border-gray-200">
                            <div class="flex justify-between items-center">
                                <h4 class="font-semibold text-gray-800">Pasangan untuk Dicocokkan</h4>
                                <button type="button" @click="matchingOptions.push({prompt: '', answer: ''})" class="px-3 py-1 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-600">+ Tambah Pasangan</button>
                            </div>
                            <template x-for="(option, index) in matchingOptions" :key="index">
                                <div class="flex gap-4 items-center p-2 rounded-md border">
                                    <div class="flex-1">
                                        <label :for="'prompt_' + index" class="text-xs text-gray-600">Pertanyaan</label>
                                        <input :name="`options[${index}][prompt]`" :id="'prompt_' + index" x-model="option.prompt" type="text" class="block w-full text-sm rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div class="flex-1">
                                        <label :for="'answer_' + index" class="text-xs text-gray-600">Jawaban</label>
                                        <input :name="`options[${index}][answer]`" :id="'answer_' + index" x-model="option.answer" type="text" class="block w-full text-sm rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <button type="button" @click="matchingOptions.splice(index, 1)" class="self-end p-2 text-red-500 hover:text-red-700">&times;</button>
                                </div>
                            </template>
                             @error('options') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- OPSI: Isi Bagian Kosong --}}
                        <div x-show="type === 'fill_in_blank'" x-transition class="p-4 mt-4 rounded-md border border-gray-200">
                            <div class="p-3 text-sm text-blue-700 bg-blue-100 rounded-md">
                                <strong>Petunjuk:</strong> Pada kotak pertanyaan, gunakan format <strong>___1___</strong>, <strong>___2___</strong>, dst. untuk menandai bagian yang kosong.
                            </div>
                            <div class="mt-4">
                                <label for="correct_answer_fib" class="block text-sm font-medium text-gray-700">Kunci Jawaban (pisahkan dengan koma)</label>
                                <input type="text" name="correct_answer" id="correct_answer_fib" value="{{ old('correct_answer', $activity->correct_answer) }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" placeholder="jawaban1, jawaban2, jawaban3">
                                @error('correct_answer') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- OPSI: Essay --}}
                        <div x-show="type === 'essay'" x-transition class="p-4 mt-4 rounded-md border border-gray-200">
                            <label for="correct_answer_essay" class="block text-sm font-medium text-gray-700">Kunci Jawaban / Jawaban Model (Opsional)</label>
                            <textarea name="correct_answer" id="correct_answer_essay" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('correct_answer', $activity->correct_answer) }}</textarea>
                            @error('correct_answer') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="flex justify-between items-center mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.materials.show', $activity->reading_material_id) }}" class="text-sm text-gray-600 hover:underline">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>