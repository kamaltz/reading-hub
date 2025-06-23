<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Tambah Aktivitas HOTS untuk "{{ $readingMaterial->title }}"
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.materials.activities.store', $readingMaterial) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                            <textarea name="question" id="question" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('question') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipe Pertanyaan</label>
                            <select name="type" id="type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                <option value="essay" @if(old('type', 'essay') == 'essay') selected @endif>Essay</option>
                                <option value="multiple_choice" @if(old('type') == 'multiple_choice') selected @endif>Pilihan Ganda</option>
                            </select>
                        </div>

                        {{-- Container untuk Jawaban Essay (ditampilkan/disembunyikan oleh JS) --}}
                        <div id="essay-answer-container" class="mb-4">
                            <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban (Essay)</label>
                            <textarea name="answer" id="answer" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('answer') }}</textarea>
                        </div>

                        {{-- Container untuk Pilihan Ganda (ditampilkan/disembunyikan oleh JS) --}}
                        <div id="mc-container" class="hidden p-4 mb-4 bg-gray-50 rounded-md border">
                            <label class="block text-sm font-medium text-gray-700">Opsi Jawaban</label>
                            <div class="mt-2 space-y-2">
                                @foreach (['A', 'B', 'C', 'D'] as $optionKey)
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold">{{ $optionKey }}.</span>
                                    <input type="text" name="options[{{ $optionKey }}]" value="{{ old('options.'.$optionKey) }}" class="block w-full rounded-md border-gray-300 shadow-sm" placeholder="Teks untuk opsi {{ $optionKey }}">
                                </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <label for="answer_key" class="block text-sm font-medium text-gray-700">Kunci Jawaban (Pilihan Ganda)</label>
                                <select name="answer_key" id="answer_key" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Pilih Kunci Jawaban</option>
                                    @foreach (['A', 'B', 'C', 'D'] as $optionKey)
                                    <option value="{{ $optionKey }}" @if(old('answer_key') == $optionKey) selected @endif>{{ $optionKey }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700">
                                Simpan Aktivitas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const essayContainer = document.getElementById('essay-answer-container');
            const mcContainer = document.getElementById('mc-container');

            function toggleActivityFields() {
                if (typeSelect.value === 'multiple_choice') {
                    essayContainer.classList.add('hidden');
                    mcContainer.classList.remove('hidden');
                } else {
                    essayContainer.classList.remove('hidden');
                    mcContainer.classList.add('hidden');
                }
            }

            typeSelect.addEventListener('change', toggleActivityFields);
            // Jalankan saat halaman dimuat untuk mengatur tampilan awal
            toggleActivityFields();
        });
    </script>
    @endpush

</x-app-layout>