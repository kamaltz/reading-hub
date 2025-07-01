<x-app-layout>
    <div class="text-gray-100">
        <!-- Recent Activities -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Pembelajaran Terbaru</h3>
                
                @if($recentAnswers->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentAnswers as $answer)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            @if($answer->is_correct)
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-sm font-medium text-green-800">Jawaban Benar</span>
                                            @else
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                                                </svg>
                                                <span class="text-sm font-medium text-red-800">Jawaban Salah</span>
                                            @endif
                                        </div>
                                        
                                        <h4 class="font-semibold text-gray-900 mb-1">{{ $answer->hotsActivity->readingMaterial->title ?? 'Materi Tidak Ditemukan' }}</h4>
                                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($answer->hotsActivity->question ?? 'Pertanyaan tidak tersedia', 100) }}</p>
                                        
                                        <div class="bg-gray-100 rounded-lg p-3 mb-2">
                                            <p class="text-xs text-gray-500 mb-1">Jawaban Anda:</p>
                                            <p class="text-sm font-medium text-gray-800">{{ $answer->answer }}</p>
                                        </div>
                                        
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-gray-500">{{ $answer->created_at->diffForHumans() }}</span>
                                            <a href="{{ route('materials.show', $answer->hotsActivity->readingMaterial->id) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                Lihat Materi →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $recentAnswers->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Aktivitas</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai belajar dengan mengerjakan soal-soal di materi pembelajaran.</p>
                        <div class="mt-6">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Mulai Belajar
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>