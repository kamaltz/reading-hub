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
            $latestStudents = User::where('role', 'student')->latest()->take(5)->get();

            // Kirim semua data statistik ke view dashboard admin
            return view('dashboard', [
                'studentsCount' => $studentsCount,
                'materialsCount' => $materialsCount,
                'genresCount' => $genresCount,
                'chaptersCount' => $chaptersCount,
                'latestStudents' => $latestStudents,
            ]);
        } 
        
        // ===================================
        // Tampilan untuk Pengguna Siswa
        // ===================================
        else {
            // --- Logika untuk Filter Materi ---
            $materialsQuery = ReadingMaterial::with(['genre', 'chapter']); // Eager load relasi

            // Filter berdasarkan chapter_id jika ada di request URL
            if ($request->filled('chapter_id')) {
                $materialsQuery->where('chapter_id', $request->chapter_id);
            }

            // Filter berdasarkan genre_id jika ada di request URL
            if ($request->filled('genre_id')) {
                $materialsQuery->where('genre_id', $request->genre_id);
            }

            $materials = $materialsQuery->latest()->paginate(12); // Gunakan paginate untuk daftar materi

            // Kirim semua data ke view dashboard siswa
            return view('dashboard', [
                // Data untuk Filter dan Daftar Materi
                'genres' => Genre::all(),
                'chapters' => Chapter::all(),
                'materials' => $materials,
            ]);
        }
    }
}