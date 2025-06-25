<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Konten Materi -->
            <div class="overflow-hidden mb-8 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($material->illustration_path)
                        <img src="{{ asset('storage/' . $material->illustration_path) }}" alt="Ilustrasi {{ $material->title }}" class="object-cover mb-4 w-full h-64 rounded-md">
                    @endif
                    {{-- Menggunakan nl2br untuk menghormati baris baru dan e() untuk keamanan --}}
                    <div class="max-w-none prose">
                        {!! nl2br(e($material->content)) !!}
                    </div>
                </div>
            </div>

            <!-- Bagian Aktivitas HOTS -->
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-4 text-2xl font-bold">Aktivitas HOTS</h3>

                    @if(session('success'))
                        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse ($activities as $activity)
                        @php
                            // Cek apakah siswa sudah menjawab aktivitas ini
                            $userAnswer = $userAnswers->get($activity->id);
                        @endphp
                        <div class="py-6 border-t border-gray-200">
                            <p class="mb-2 font-semibold">{{ $loop->iteration }}. {{ $activity->question }}</p>

                            @if($userAnswer)
                                <!-- Tampilkan jawaban yang sudah dikirim -->
                                <div class="p-4 bg-gray-100 rounded-md">
                                    <p class="text-sm text-gray-600">Jawaban Anda:</p>
                                    <p class="font-medium">{{ $userAnswer->student_answer }}</p>
                                    @if($activity->type === 'multiple_choice')
                                        @if($userAnswer->is_correct)
                                            <p class="mt-2 text-sm font-semibold text-green-600">Jawaban Benar</p>
                                        @else
                                            <p class="mt-2 text-sm font-semibold text-red-600">Jawaban Salah. Kunci Jawaban: {{ $activity->answer_key }}</p>
                                        @endif
                                    @else
                                        <p class="mt-2 text-sm text-blue-600">Jawaban esai Anda akan segera diperiksa.</p>
                                    @endif
                                </div>
                            @else
                                <!-- Tampilkan form jawaban -->
                                <form action="{{ route('activities.answer', $activity) }}" method="POST">
                                    @csrf
                                    @if ($activity->type == 'multiple_choice')
                                        <div class="space-y-2">
                                            @foreach ($activity->options as $option)
                                                <label class="flex items-center">
                                                    <input type="radio" name="option" value="{{ $option }}" class="form-radio" required>
                                                    <span class="ml-2">{{ $option }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @elseif ($activity->type == 'essay')
                                        <textarea name="student_answer" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" placeholder="Tulis jawaban Anda di sini..." required></textarea>
                                    @endif
                                    <x-primary-button class="mt-4">Kirim Jawaban</x-primary-button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada aktivitas untuk materi ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>