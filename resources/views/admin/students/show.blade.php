<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Progres Siswa: {{ $student->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-4 text-lg font-bold">Detail Progres</h3>

                    <div class="mb-6">
                        <p><strong>Nama:</strong> {{ $student->name }}</p>
                        <p><strong>Email:</strong> {{ $student->email }}</p>
                        <p><strong>Total Jawaban Aktivitas:</strong> {{ $student->hots_activity_answers_count }}</p>
                        <p><strong>Jawaban Benar:</strong> {{ $student->correct_answers_count }}</p>
                    </div>

                    <h4 class="mb-3 font-semibold text-md">Riwayat Jawaban Aktivitas HOTS</h4>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Materi</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Pertanyaan</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Jawaban Siswa</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Skor</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($answers as $answer)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($answer->hotsActivity && $answer->hotsActivity->readingMaterial)
                                            {{ $answer->hotsActivity->readingMaterial->title }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($answer->hotsActivity->question ?? 'N/A', 50) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($answer->student_answer, 50) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($answer->is_correct === true)
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Benar</span>
                                        @elseif ($answer->is_correct === false)
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">Salah</span>
                                        @else
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full">Belum Dinilai</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $answer->score ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $answer->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Siswa ini belum menjawab aktivitas HOTS.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $answers->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>