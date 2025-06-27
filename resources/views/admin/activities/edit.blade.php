<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Aktivitas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.activities.update', $activity->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Menggunakan Alpine.js untuk membuat form dinamis --}}
                        <div x-data="{
                            type: '{{ old('type', $activity->type) }}',
                            options: {{ json_encode(old('options', $activity->options ?? ['','','',''])) }},
                            addOption() { this.options.push(''); },
                            removeOption(index) { this.options.splice(index, 1); }
                        }">

                            <!-- Tipe Aktivitas -->
                            <div class="mb-4">
                                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Soal</label>
                                <select name="type" id="type" x-model="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="essay" @selected($activity->type == 'essay')>Essay</option>
                                    <option value="multiple_choice" @selected($activity->type == 'multiple_choice')>Pilihan Ganda</option>
                                    <option value="true_false" @selected($activity->type == 'true_false')>Benar / Salah</option>
                                </select>
                            </div>

                            <!-- Pertanyaan -->
                            <div class="mb-4">
                                <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                                <textarea name="question" id="question" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('question', $activity->question) }}</textarea>
                                @error('question') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Opsi Jawaban (hanya untuk Pilihan Ganda) -->
                            <div x-show="type === 'multiple_choice'" class="p-4 mb-4 bg-gray-50 rounded-md border">
                                <label class="block mb-2 text-sm font-medium text-gray-700">Pilihan Jawaban</label>
                                <template x-for="(option, index) in options" :key="index">
                                    <div class="flex items-center mb-2">
                                        <input type="text" :name="'options[' + index + ']'" x-model="options[index]" class="block w-full rounded-md border-gray-300 shadow-sm" :placeholder="'Pilihan ' + (index + 1)">
                                        <button type="button" @click="removeOption(index)" class="ml-2 text-lg font-bold text-red-500 hover:text-red-700">&times;</button>
                                    </div>
                                </template>
                                <button type="button" @click="addOption()" class="mt-2 text-sm font-semibold text-blue-500 hover:text-blue-700">+ Tambah Pilihan</button>
                                @error('options') <span class="block mt-2 text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <!-- Kunci Jawaban (tidak ditampilkan untuk Essay) -->
                            <div x-show="type !== 'essay'" class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Kunci Jawaban</label>
                                
                                <input x-show="type === 'multiple_choice'" type="text" name="correct_answer" value="{{ old('correct_answer', $activity->correct_answer) }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" placeholder="Tulis jawaban yang benar di sini (sama persis dengan salah satu pilihan)">
                                
                                <div x-show="type === 'true_false'" class="mt-2 space-y-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="correct_answer" value="true" class="form-radio" @checked(old('correct_answer', $activity->correct_answer) == 'true')>
                                        <span class="ml-2">Benar</span>
                                    </label>
                                    <label class="inline-flex items-center ml-4">
                                        <input type="radio" name="correct_answer" value="false" class="form-radio" @checked(old('correct_answer', $activity->correct_answer) == 'false')>
                                        <span class="ml-2">Salah</span>
                                    </label>
                                </div>
                                @error('correct_answer') <span class="block mt-2 text-sm text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end items-center mt-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                                    Perbarui Aktivitas
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
