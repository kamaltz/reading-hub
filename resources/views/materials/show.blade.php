<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Materi: {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ url()->previous() }}" class="text-indigo-600 hover:text-indigo-900">&larr; Kembali</a>
                    </div>

                    <h3 class="mb-2 text-2xl font-bold">{{ $material->title }}</h3>
                    <p class="mb-4 text-gray-600">{{ $material->description }}</p>
                    
                    {{-- Rich Text Content --}}
                    @if($material->content)
                        <div class="mb-6 prose max-w-none">
                            {!! $material->content !!}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- PERBAIKAN: Looping pada $material->activities, bukan $activities --}}
                    @forelse ($material->activities as $activity)
                        @php
                            // Cek apakah siswa sudah menjawab aktivitas ini
                            // Kita asumsikan $userAnswers sudah dikirim dari controller/route jika diperlukan
                            $userAnswer = Auth::user()->answers->keyBy('hots_activity_id')->get($activity->id);
                        @endphp
                        <div class="py-6 border-t border-gray-200">
                            <p class="mb-2 font-semibold">{{ $loop->iteration }}. {{ $activity->question }}</p>

                            @if($userAnswer)
                                <!-- Tampilkan jawaban yang sudah dikirim -->
                                <div class="p-4 bg-gray-100 rounded-md">
                                    <p class="text-sm text-gray-600">Jawaban Anda:</p>
                                    <p class="font-medium">{{ $userAnswer->answer }}</p>
                                    @if ($userAnswer->is_correct)
                                        <p class="mt-2 text-sm font-bold text-green-600">Status: Benar</p>
                                    @else
                                        <p class="mt-2 text-sm font-bold text-red-600">Status: Salah</p>
                                    @endif
                                </div>
                            @else
                                <!-- Tampilkan form untuk menjawab -->
                                <form action="{{ route('activities.answer', $activity->id) }}" method="POST">
                                    @csrf
                                    <div class="flex flex-col space-y-2">
                                        <textarea name="answer" rows="3" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Ketik jawaban Anda di sini..." required></textarea>
                                        <div class="self-end">
                                            <button type="submit" class="px-4 py-2 font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                                Kirim Jawaban
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="py-6 border-t border-gray-200">
                            <p class="text-center text-gray-500">Belum ada aktivitas untuk materi ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
