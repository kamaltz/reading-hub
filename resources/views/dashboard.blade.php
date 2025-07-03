<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="text-gray-100">
                    {{-- Tampilan untuk Admin --}}
                    @if (Auth::user()->isAdmin())
                        <!-- Key Metrics Cards -->
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
                            <!-- Student Engagement -->
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                                    <div class="space-y-1">
                                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Tingkat Partisipasi</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $studentsCount > 0 ? round(($activeStudents / $studentsCount) * 100, 1) : 0 }}%</p>
                                    </div>
                                    <div class="h-4 w-4 text-muted-foreground">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.196-2.121M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.196-2.121M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-6 pt-0">
                                    <div class="text-xs text-muted-foreground text-gray-500">{{ $activeStudents }} dari {{ $studentsCount }} siswa aktif</div>
                                </div>
                            </div>

                            <!-- Learning Success Rate -->
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                                    <div class="space-y-1">
                                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Tingkat Keberhasilan</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $averageScore }}%</p>
                                    </div>
                                    <div class="h-4 w-4 text-muted-foreground">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-6 pt-0">
                                    <div class="text-xs text-muted-foreground text-gray-500">{{ $correctAnswers }} dari {{ $totalAnswers }} jawaban benar</div>
                                </div>
                            </div>

                            <!-- Content Completion -->
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                                    <div class="space-y-1">
                                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Materi Tersedia</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $materialsCount }}</p>
                                    </div>
                                    <div class="h-4 w-4 text-muted-foreground">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-6 pt-0">
                                    <div class="text-xs text-muted-foreground text-gray-500">{{ $activitiesCount }} aktivitas pembelajaran</div>
                                </div>
                            </div>

                            <!-- Activity Volume -->
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                                    <div class="space-y-1">
                                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Total Interaksi</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $totalAnswers }}</p>
                                    </div>
                                    <div class="h-4 w-4 text-muted-foreground">
                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-6 pt-0">
                                    <div class="text-xs text-muted-foreground text-gray-500">Jawaban siswa pada aktivitas</div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Analytics -->
                        <div class="grid gap-6 md:grid-cols-2 mb-6">
                            <!-- Learning Progress Chart -->
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Progres Pembelajaran</h3>
                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600">Siswa Aktif</span>
                                                <span class="font-medium text-gray-900">{{ $activeStudents }}/{{ $studentsCount }}</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $studentsCount > 0 ? ($activeStudents / $studentsCount) * 100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600">Tingkat Keberhasilan</span>
                                                <span class="font-medium text-gray-900">{{ $averageScore }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: {{ $averageScore }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-green-600">{{ $correctAnswers }}</div>
                                                <div class="text-xs text-gray-500">Jawaban Benar</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-red-600">{{ $totalAnswers - $correctAnswers }}</div>
                                                <div class="text-xs text-gray-500">Jawaban Salah</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Students -->
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Siswa Terbaru</h3>
                                    <div class="space-y-3">
                                        @forelse($latestStudents as $student)
                                            <div class="flex items-center space-x-3 p-3 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <span class="text-sm font-medium text-blue-600">{{ substr($student->name, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $student->name }}</p>
                                                    <p class="text-xs text-gray-500 truncate">{{ $student->email }}</p>
                                                </div>
                                                <div class="text-xs text-gray-400">{{ $student->created_at->diffForHumans() }}</div>
                                            </div>
                                        @empty
                                            <div class="text-center py-6">
                                                <p class="text-gray-500 text-sm">Belum ada siswa terdaftar</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity Table -->
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Pembelajaran Terbaru</h3>
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="border-b border-gray-200">
                                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Siswa</th>
                                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Materi</th>
                                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Status</th>
                                                <th class="text-left py-3 px-4 font-medium text-gray-600 text-sm">Waktu</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @forelse($recentAnswers as $answer)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="py-3 px-4">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center">
                                                                <span class="text-xs font-medium text-gray-600">{{ substr($answer->user->name, 0, 1) }}</span>
                                                            </div>
                                                            <span class="text-sm font-medium text-gray-900">{{ $answer->user->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-4 text-sm text-gray-600">{{ Str::limit($answer->hotsActivity->readingMaterial->title ?? 'N/A', 30) }}</td>
                                                    <td class="py-3 px-4">
                                                        @if($answer->is_correct)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Benar</span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Salah</span>
                                                        @endif
                                                    </td>
                                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $answer->created_at->diffForHumans() }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="py-6 text-center text-gray-500 text-sm">Belum ada aktivitas pembelajaran</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    {{-- Tampilan untuk Siswa --}}
                    @else
                        <!-- Student Progress Statistics -->
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
                            <!-- Activities Attempted -->
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                                    <div class="space-y-1">
                                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Aktivitas Dicoba</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $totalAttemptedActivities }}</p>
                                    </div>
                                    <div class="h-4 w-4 text-muted-foreground">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-6 pt-0">
                                    <div class="text-xs text-muted-foreground text-gray-500">dari {{ $totalAvailableActivities }} total aktivitas</div>
                                </div>
                            </div>

                            <!-- Correct Answers -->
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                                    <div class="space-y-1">
                                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Jawaban Benar</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $completedActivities }}</p>
                                    </div>
                                    <div class="h-4 w-4 text-muted-foreground">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-6 pt-0">
                                    <div class="text-xs text-muted-foreground text-gray-500">{{ $totalAttemptedActivities > 0 ? round(($completedActivities / $totalAttemptedActivities) * 100, 1) : 0 }}% tingkat keberhasilan</div>
                                </div>
                            </div>

                            <!-- Materials Progress -->
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                                    <div class="space-y-1">
                                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Materi Dipelajari</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $materials->where(function($material) use ($userAnsweredActivityIds) { return $material->activities->whereIn('id', $userAnsweredActivityIds)->count() > 0; })->count() }}</p>
                                    </div>
                                    <div class="h-4 w-4 text-muted-foreground">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-6 pt-0">
                                    <div class="text-xs text-muted-foreground text-gray-500">dari {{ $materials->count() }} materi tersedia</div>
                                </div>
                            </div>

                            <!-- Overall Progress -->
                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200">
                                <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                                    <div class="space-y-1">
                                        <p class="text-sm font-medium text-muted-foreground text-gray-600">Progres Keseluruhan</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $totalAvailableActivities > 0 ? round(($totalAttemptedActivities / $totalAvailableActivities) * 100, 1) : 0 }}%</p>
                                    </div>
                                    <div class="h-4 w-4 text-muted-foreground">
                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-6 pt-0">
                                    <div class="text-xs text-muted-foreground text-gray-500">pembelajaran yang diselesaikan</div>
                                </div>
                            </div>
                        </div>

                        <!-- Materials Grid -->
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm bg-white border-gray-200 mb-6">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Materi Pembelajaran</h3>
                                    <div class="flex space-x-2">
                                        <select id="chapterFilter" class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Semua Bab</option>
                                            @foreach ($chapters as $chapter)
                                                <option value="{{ $chapter->id }}">{{ $chapter->title }}</option>
                                            @endforeach
                                        </select>
                                        <select id="genreFilter" class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Semua Genre</option>
                                            @foreach ($genres as $genre)
                                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                                    @forelse ($materials as $material)
                                        @php
                                            $totalActivitiesInMaterial = $material->activities->count();
                                            $answeredActivitiesInMaterial = $material->activities->whereIn('id', $userAnsweredActivityIds)->count();
                                            $correctAnswersInMaterial = $material->activities->filter(function($activity) use ($userAnsweredActivityIds) {
                                                return in_array($activity->id, $userAnsweredActivityIds) && 
                                                       Auth::user()->answers->where('hots_activity_id', $activity->id)->where('is_correct', true)->count() > 0;
                                            })->count();
                                            $progress = ($totalActivitiesInMaterial > 0) ? round(($answeredActivitiesInMaterial / $totalActivitiesInMaterial) * 100) : 0;
                                            $score = ($answeredActivitiesInMaterial > 0) ? round(($correctAnswersInMaterial / $answeredActivitiesInMaterial) * 100) : 0;
                                        @endphp
                                        <div class="material-card border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow" data-chapter="{{ $material->chapter_id }}" data-genre="{{ $material->genre_id }}">
                                            <div class="flex items-start justify-between mb-3">
                                                <h4 class="font-semibold text-gray-900 text-sm truncate pr-2 flex-1" title="{{ $material->title }}">{{ $material->title }}</h4>
                                                @if($progress > 0)
                                                    <span class="text-xs px-2 py-1 rounded-full whitespace-nowrap {{ $progress == 100 ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                        {{ $progress }}%
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <p class="text-xs text-gray-500 mb-3 truncate">{{ $material->chapter->title ?? 'N/A' }} • {{ $material->genre->name ?? 'N/A' }}</p>
                                            
                                            @if($material->description)
                                                <p class="text-xs text-gray-600 mb-3 line-clamp-2 overflow-hidden" title="{{ $material->description }}">{{ $material->description }}</p>
                                            @endif
                                            
                                            @if ($totalActivitiesInMaterial > 0)
                                                <div class="space-y-2 mb-4">
                                                    <div class="flex justify-between text-xs text-gray-600">
                                                        <span>Progres: {{ $answeredActivitiesInMaterial }}/{{ $totalActivitiesInMaterial }}</span>
                                                        <span>Nilai: {{ $score }}%</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-xs text-gray-500 mb-4">Belum ada aktivitas</p>
                                            @endif
                                            
                                            <a href="{{ route('materials.show', $material) }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                                Belajar Sekarang
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="col-span-full text-center py-8">
                                            <p class="text-gray-500">Belum ada materi pembelajaran tersedia</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
