<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReadingMaterial;
use App\Models\User;
use Illuminate\Http\Request;

class StudentProgressController extends Controller
{
    /**
     * Menampilkan daftar semua siswa beserta rangkuman progresnya.
     */
    public function index()
    {
        $students = User::where('role', 'student')
                        ->withCount(['answers as correct_answers_count' => function ($query) {
                            $query->where('is_correct', true);
                        }])
                        ->withCount('answers as attempted_answers_count')
                        ->latest()
                        ->paginate(15);
        
        return view('admin.students.index', compact('students'));
    }

    /**
     * Menampilkan progres detail dari seorang siswa.
     */
    public function show(User $student)
    {
        // Ambil semua materi beserta aktivitasnya
        $materials = ReadingMaterial::with('activities')->get();
        
        // Ambil semua jawaban siswa untuk di-mapping di view
        $studentAnswers = $student->answers()
                                  ->with('hotsActivity')
                                  ->get()
                                  ->keyBy('hots_activity_id');
        
        return view('admin.students.show', compact('student', 'materials', 'studentAnswers'));
    }
}