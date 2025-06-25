<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\HotsActivity;
use App\Models\ReadingMaterial;
use App\Models\StudentHotsActivityAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Logika untuk Admin
            return view('dashboard', [
                'totalMaterials' => ReadingMaterial::count(),
                'totalActivities' => HotsActivity::count(),
                'totalStudents' => User::where('role', 'student')->count(),
                'totalAnswers' => StudentHotsActivityAnswer::count(),
            ]);
        } else {
            // Logika untuk Siswa
            $totalAttemptedActivities = $user->answers()->distinct('hots_activity_id')->count();
            $completedActivities = $user->answers()->where('is_correct', true)->distinct('hots_activity_id')->count();
            $totalAvailableActivities = HotsActivity::count();

            // Ambil data untuk filter
            $chapters = Chapter::orderBy('title')->get(); // <-- INI DIA PERBAIKANNYA
            $genres = Genre::orderBy('name')->get();

            // Query dasar untuk materi
            $materialsQuery = ReadingMaterial::query();

            // Terapkan filter jika ada
            if ($request->filled('chapter_id')) {
                $materialsQuery->where('chapter_id', $request->chapter_id);
            }

            if ($request->filled('genre_id')) {
                $materialsQuery->where('genre_id', $request->genre_id);
            }
            
            // Ambil hasil query
            $materials = $materialsQuery->with('activities')->get();

            return view('dashboard', [
                'totalAttemptedActivities' => $totalAttemptedActivities,
                'completedActivities' => $completedActivities,
                'totalAvailableActivities' => $totalAvailableActivities,
                'materials' => $materials,
                'chapters' => $chapters,
                'genres' => $genres,
            ]);
        }
    }
}