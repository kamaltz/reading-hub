<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Materi: {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bg-white">
                    <div class="mb-6">
                        <a href="{{ url()->previous() }}" class="text-indigo-600 hover:text-indigo-900">&larr; Kembali</a>
                    </div>

                    <h3 class="mb-2 text-2xl font-bold">{{ $material->title }}</h3>
                    <p class="mb-4 text-gray-600">{{ $material->description }}</p>
                    
                    {{-- Rich Text Content --}}
                    @if($material->content)
                        <div class="mb-6 prose max-w-none prose-material">
                            <div class="text-gray-900 bg-white p-6 rounded-lg border border-gray-200">
                                <style>
                                    .prose-material * { color: #374151 !important; }
                                    .prose-material h1, .prose-material h2, .prose-material h3, .prose-material h4, .prose-material h5, .prose-material h6 { color: #111827 !important; font-weight: 600; }
                                    .prose-material p { color: #374151 !important; line-height: 1.7; }
                                    .prose-material strong { color: #111827 !important; font-weight: 600; }
                                    .prose-material ul, .prose-material ol, .prose-material li { color: #374151 !important; }
                                </style>
                                {!! $material->content !!}
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @php
                        $userAnswers = Auth::user()->answers()->whereIn('hots_activity_id', $material->activities->pluck('id'))->get();
                        $hasAnswered = $userAnswers->count() > 0;
                        $totalQuestions = $material->activities->count();
                        $correctAnswers = $userAnswers->where('is_correct', true)->count();
                        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;
                    @endphp

                    @if($hasAnswered)
                        <!-- Show Results -->
                        <div class="mb-6 p-6 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-blue-900 mb-2">Hasil Pembelajaran</h3>
                                <div class="text-4xl font-bold text-blue-600 mb-2">{{ $score }}%</div>
                                <p class="text-blue-800">{{ $correctAnswers }} dari {{ $totalQuestions }} jawaban benar</p>
                            </div>
                        </div>

                        <!-- Show Questions with Answers -->
                        @foreach ($material->activities as $activity)
                            @php
                                $userAnswer = $userAnswers->where('hots_activity_id', $activity->id)->first();
                            @endphp
                            <div class="py-6 border-t border-gray-200">
                                <div class="mb-4">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $loop->iteration }}. {{ $activity->question }}</h4>
                                    @if($activity->image)
                                        <img src="{{ asset('storage/' . $activity->image) }}" alt="Question Image" class="max-w-md h-auto mb-4 rounded-lg shadow-md">
                                    @endif
                                </div>
                                
                                @if($userAnswer)
                                    <div class="space-y-3">
                                        <!-- User's Answer -->
                                        <div class="p-4 {{ $userAnswer->is_correct ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }} rounded-lg">
                                            <div class="flex items-center mb-2">
                                                @if($userAnswer->is_correct)
                                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="font-semibold text-green-800">Jawaban Benar</span>
                                                @else
                                                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                                                    </svg>
                                                    <span class="font-semibold text-red-800">Jawaban Salah</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 mb-1">Jawaban Anda:</p>
                                            <p class="font-medium text-gray-900">
                                                @if($activity->type === 'multiple_choice' && $activity->options && is_array($activity->options))
                                                    {{ $userAnswer->student_answer }}. {{ $activity->options[$userAnswer->student_answer] ?? $userAnswer->student_answer }}
                                                @elseif($activity->type === 'true_false')
                                                    {{ $userAnswer->student_answer === 'true' ? 'Benar' : 'Salah' }}
                                                @else
                                                    {{ $userAnswer->student_answer }}
                                                @endif
                                            </p>
                                        </div>
                                        
                                        <!-- Correct Answer (if wrong) -->
                                        @if(!$userAnswer->is_correct)
                                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                                <p class="text-sm text-blue-600 mb-1">Jawaban yang benar:</p>
                                                <p class="font-medium text-blue-900">
                                                    @php
                                                        $correctAnswer = is_array($activity->correct_answer) ? $activity->correct_answer[0] : $activity->correct_answer;
                                                    @endphp
                                                    @if($activity->type === 'multiple_choice' && $activity->options && is_array($activity->options))
                                                        {{ $correctAnswer }}. {{ $activity->options[$correctAnswer] ?? $correctAnswer }}
                                                    @elseif($activity->type === 'true_false')
                                                        {{ strtolower($correctAnswer) === 'true' ? 'Benar' : 'Salah' }}
                                                    @else
                                                        {{ $correctAnswer }}
                                                    @endif
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <!-- Quiz Form -->
                        @if($material->activities->count() > 0)
                            <form action="{{ route('materials.submit', $material->id) }}" method="POST" class="space-y-6">
                                @csrf
                                
                                @foreach ($material->activities as $activity)
                                    <div class="py-6 border-t border-gray-200">
                                        <div class="mb-4">
                                            <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $loop->iteration }}. {{ $activity->question }}</h4>
                                            @if($activity->image)
                                                <img src="{{ asset('storage/' . $activity->image) }}" alt="Question Image" class="max-w-md h-auto mb-4 rounded-lg shadow-md">
                                            @endif
                                        </div>

                                        @if($activity->type === 'multiple_choice' || $activity->type === 'image_based')
                                            <div class="space-y-2">
                                                @if($activity->options && is_array($activity->options))
                                                    @foreach($activity->options as $key => $option)
                                                        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                            <input type="radio" name="answers[{{ $activity->id }}]" value="{{ $key }}" class="mr-3 text-indigo-600" required>
                                                            <span class="text-gray-900">{{ $key }}. {{ $option }}</span>
                                                        </label>
                                                    @endforeach
                                                @endif
                                            </div>
                                        
                                        @elseif($activity->type === 'true_false')
                                            <div class="space-y-2">
                                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                    <input type="radio" name="answers[{{ $activity->id }}]" value="true" class="mr-3 text-indigo-600" required>
                                                    <span class="text-gray-900">Benar</span>
                                                </label>
                                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                                    <input type="radio" name="answers[{{ $activity->id }}]" value="false" class="mr-3 text-indigo-600" required>
                                                    <span class="text-gray-900">Salah</span>
                                                </label>
                                            </div>
                                        
                                        @elseif($activity->type === 'fill_in_blank')
                                            <div>
                                                <input type="text" name="answers[{{ $activity->id }}]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan jawaban Anda..." required>
                                            </div>
                                        
                                        @else
                                            <div>
                                                <textarea name="answers[{{ $activity->id }}]" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tulis jawaban Anda di sini..." required></textarea>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                <div class="flex justify-center py-6">
                                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-semibold text-lg rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                                        Submit Semua Jawaban
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="py-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="mt-2 text-gray-500">Belum ada aktivitas untuk materi ini.</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
