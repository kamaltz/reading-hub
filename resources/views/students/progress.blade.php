<x-app-layout>
    <div class="text-gray-100">
        <!-- Progress Overview -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
            @php
                $totalAnswers = $userAnswers->count();
                $correctAnswers = $userAnswers->where('is_correct', true)->count();
                $totalMaterials = $materials->count();
                $studiedMaterials = $materials->filter(function($material) use ($userAnswers) {
                    return $userAnswers->whereIn('hots_activity_id', $material->activities->pluck('id'))->count() > 0;
                })->count();
            @endphp
            
            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Total Jawaban</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalAnswers }}</p>
                    </div>
                    <div class="h-4 w-4 text-muted-foreground">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Jawaban Benar</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $correctAnswers }}</p>
                    </div>
                    <div class="h-4 w-4 text-muted-foreground">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-xs text-muted-foreground text-gray-500">{{ $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100, 1) : 0 }}% akurasi</div>
                </div>
            </div>

            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Materi Dipelajari</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $studiedMaterials }}</p>
                    </div>
                    <div class="h-4 w-4 text-muted-foreground">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <div class="text-xs text-muted-foreground text-gray-500">dari {{ $totalMaterials }} materi</div>
                </div>
            </div>

            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Progres Keseluruhan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalMaterials > 0 ? round(($studiedMaterials / $totalMaterials) * 100) : 0 }}%</p>
                    </div>
                    <div class="h-4 w-4 text-muted-foreground">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Material Progress Details -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Progres per Materi</h3>
                <div class="space-y-4">
                    @foreach($materials as $material)
                        @php
                            $materialAnswers = $userAnswers->whereIn('hots_activity_id', $material->activities->pluck('id'));
                            $totalQuestions = $material->activities->count();
                            $answeredQuestions = $materialAnswers->count();
                            $correctInMaterial = $materialAnswers->where('is_correct', true)->count();
                            $progress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
                            $score = $answeredQuestions > 0 ? round(($correctInMaterial / $answeredQuestions) * 100) : 0;
                        @endphp
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $material->title }}</h4>
                                <span class="text-sm px-2 py-1 rounded-full {{ $progress == 100 ? 'bg-green-100 text-green-800' : ($progress > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600') }}">
                                    {{ $progress }}%
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-3">{{ $material->chapter->title ?? 'N/A' }} • {{ $material->genre->name ?? 'N/A' }}</p>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Progres: {{ $answeredQuestions }}/{{ $totalQuestions }} soal</span>
                                    @if($answeredQuestions > 0)
                                        <span>Skor: {{ $score }}%</span>
                                    @endif
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <a href="{{ route('materials.show', $material) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    {{ $progress == 100 ? 'Lihat Hasil' : 'Lanjutkan Belajar' }} →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>