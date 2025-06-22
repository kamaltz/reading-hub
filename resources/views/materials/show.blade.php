<x-guest-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <article>
            {{-- Bagian Judul dan Info Materi --}}
            <div class="mb-8 border-b pb-4">
                <h1 class="text-4xl font-bold text-gray-900">{{ $material->title }}</h1>
                <p class="text-lg text-gray-500 mt-2">
                    {{ $material->chapter->title }} | Genre: {{ $material->genre->name }}
                </p>
            </div>

            {{-- Menampilkan Ilustrasi jika ada --}}
            @if ($material->illustration_path)
                <div class="mb-8">
                    <img src="{{ asset('storage/' . $material->illustration_path) }}" alt="{{ $material->title }}" class="w-full h-auto object-cover rounded-lg shadow-lg">
                </div>
            @endif

            {{-- Menampilkan Konten Utama Materi --}}
            <div class="prose max-w-none">
                {!! nl2br(e($material->content)) !!}
            </div>
            
            {{-- BAGIAN INI YANG DIPERBARUI --}}
            {{-- Menampilkan Daftar Aktivitas HOTS --}}
            <div class="mt-12 border-t pt-8">
                <h2 class="text-2xl font-bold mb-6">Aktivitas</h2>

                {{-- Looping melalui setiap aktivitas yang dimiliki materi ini --}}
                @forelse ($material->hotsActivities as $activity)
                    <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                        {{-- Menampilkan nomor urut dan pertanyaan --}}
                        <p class="font-semibold text-gray-800">{{ $loop->iteration }}. {{ $activity->question }}</p>

                        {{-- Jika tipe pertanyaan adalah pilihan ganda --}}
                        @if ($activity->type == 'multiple_choice' && is_array($activity->options))
                            <div class="mt-4 space-y-2">
                                {{-- Looping untuk setiap pilihan jawaban --}}
                                @foreach ($activity->options as $key => $option)
                                    <label class="flex items-center text-gray-700">
                                        {{-- Input radio dikelompokkan berdasarkan ID aktivitas --}}
                                        <input type="radio" name="activity_{{ $activity->id }}" value="{{ $key }}" class="form-radio text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-3">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                        {{-- Jika tipe pertanyaan adalah essay --}}
                        @elseif ($activity->type == 'essay')
                            <textarea rows="4" class="mt-4 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tulis jawabanmu di sini..."></textarea>
                        @endif
                    </div>
                {{-- Jika tidak ada aktivitas sama sekali --}}
                @empty
                    <p class="text-gray-500">Belum ada aktivitas untuk materi ini.</p>
                @endforelse
            </div>
            
        </article>
    </div>
</x-guest-layout>