<?php

namespace App\Http\Controllers;

// Import semua model dan class yang dibutuhkan
use App\Models\User;
use App\Models\Genre;
use App\Models\Chapter;
use App\Models\HotsActivity;
use App\Models\ReadingMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard yang sesuai berdasarkan peran pengguna.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        // ===================================
        // Tampilan untuk Pengguna Admin
        // ===================================
        if ($user->isAdmin()) {
            $studentsCount = User::where('role', 'student')->count();
            $materialsCount = ReadingMaterial::count();
            $genresCount = Genre::count();
            $chaptersCount = Chapter::count();
            $activitiesCount = HotsActivity::count();
            
            // Student progress statistics
            $totalAnswers = \App\Models\StudentHotsActivityAnswer::count();
            $correctAnswers = \App\Models\StudentHotsActivityAnswer::where('is_correct', true)->count();
            $averageScore = $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100, 1) : 0;
            
            // Active students (students who have answered at least one activity)
            $activeStudents = User::where('role', 'student')
                ->whereHas('answers')
                ->count();
            
            $latestStudents = User::where('role', 'student')->latest()->take(5)->get();
            
            // Recent activities
            $recentAnswers = \App\Models\StudentHotsActivityAnswer::with(['user', 'hotsActivity.readingMaterial'])
                ->latest()
                ->take(10)
                ->get();

            return view('dashboard', [
                'studentsCount' => $studentsCount,
                'materialsCount' => $materialsCount,
                'genresCount' => $genresCount,
                'chaptersCount' => $chaptersCount,
                'activitiesCount' => $activitiesCount,
                'totalAnswers' => $totalAnswers,
                'correctAnswers' => $correctAnswers,
                'averageScore' => $averageScore,
                'activeStudents' => $activeStudents,
                'latestStudents' => $latestStudents,
                'recentAnswers' => $recentAnswers,
            ]);
        } 
        
        // ===================================
        // Tampilan untuk Pengguna Siswa
        // ===================================
        else {
            // --- Logika untuk Filter Materi ---
            $materialsQuery = ReadingMaterial::with(['genre', 'chapter', 'activities']); // Eager load relasi

            // Filter berdasarkan chapter_id jika ada di request URL
            if ($request->filled('chapter_id')) {
                $materialsQuery->where('chapter_id', $request->chapter_id);
            }

            // Filter berdasarkan genre_id jika ada di request URL
            if ($request->filled('genre_id')) {
                $materialsQuery->where('genre_id', $request->genre_id);
            }

            $materials = $materialsQuery->latest()->paginate(12); // Gunakan paginate untuk daftar materi

            // Statistics for student
            $totalAttemptedActivities = $user->answers()->count();
            $completedActivities = $user->answers()->where('is_correct', true)->count();
            $totalAvailableActivities = HotsActivity::count();
            $userAnsweredActivityIds = $user->answers()->pluck('hots_activity_id')->toArray();

            // Kirim semua data ke view dashboard siswa
            return view('dashboard', [
                // Data untuk Filter dan Daftar Materi
                'genres' => Genre::all(),
                'chapters' => Chapter::all(),
                'materials' => $materials,
                // Statistics
                'totalAttemptedActivities' => $totalAttemptedActivities,
                'completedActivities' => $completedActivities,
                'totalAvailableActivities' => $totalAvailableActivities,
                'userAnsweredActivityIds' => $userAnsweredActivityIds,
            ]);
        }
    }
}