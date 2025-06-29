<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Genre;
use App\Models\Chapter;
use App\Models\HotsActivity;
use App\Models\ReadingMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return View
     */
    public function __invoke(Request $request): View
    {
        $user = Auth::user();

        // Tampilan untuk Admin
        if ($user->isAdmin()) {
            $studentsCount = User::where('role', 'student')->count();
            $materialsCount = ReadingMaterial::count();
            $genresCount = Genre::count();
            $chaptersCount = Chapter::count();
            $latestStudents = User::where('role', 'student')->latest()->take(5)->get();

            return view('dashboard', [
                'studentsCount' => $studentsCount,
                'materialsCount' => $materialsCount,
                'genresCount' => $genresCount,
                'chaptersCount' => $chaptersCount,
                'latestStudents' => $latestStudents,
            ]);
        } 
        
        // Tampilan untuk Siswa
        else {
            // --- Kalkulasi Data Statistik ---
            $totalAvailableActivities = HotsActivity::count();
            $userAnswersQuery = $user->answers(); // Ambil query builder untuk jawaban user
            $totalAttemptedActivities = $userAnswersQuery->count();
            $completedActivities = (clone $userAnswersQuery)->where('is_correct', true)->count();
            
            // Ambil semua ID aktivitas yang pernah dijawab user (untuk progress bar)
            $userAnsweredActivityIds = (clone $userAnswersQuery)->pluck('hots_activity_id');

            // --- Logika untuk Filter Materi ---
            $materialsQuery = ReadingMaterial::with(['activities', 'chapter.genre']); // Eager load

            // Filter berdasarkan chapter_id jika ada
            if ($request->filled('chapter_id')) {
                $materialsQuery->where('chapter_id', $request->chapter_id);
            }

            // Filter berdasarkan genre_id jika ada
            if ($request->filled('genre_id')) {
                $materialsQuery->whereHas('chapter', function ($query) use ($request) {
                    $query->where('genre_id', $request->genre_id);
                });
            }

            $materials = $materialsQuery->latest()->get();

            return view('dashboard', [
                // Data Statistik
                'totalAvailableActivities' => $totalAvailableActivities,
                'totalAttemptedActivities' => $totalAttemptedActivities,
                'completedActivities' => $completedActivities,
                
                // Data untuk Filter dan Daftar Materi
                'genres' => Genre::all(),
                'chapters' => Chapter::all(),
                'materials' => $materials,

                // Data untuk Kalkulasi Progress di View
                'userAnsweredActivityIds' => $userAnsweredActivityIds,
            ]);
        }
    }
}