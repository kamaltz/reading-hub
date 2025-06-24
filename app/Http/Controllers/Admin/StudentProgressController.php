<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentProgressController extends Controller
{
    /**
     * Menampilkan daftar semua siswa dengan ringkasan progres.
     */
    public function index()
    {
        // Ambil semua user dengan role 'student'
        $students = User::where('role', 'student')
                        ->withCount('hotsActivityAnswers') // Menghitung total jawaban
                        ->withCount(['hotsActivityAnswers as correct_answers_count' => function ($query) {
                            $query->where('is_correct', true);
                        }]) // Menghitung jawaban benar
                        ->latest()
                        ->paginate(10);

        return view('admin.students.index', compact('students'));
    }

    /**
     * Menampilkan detail progres untuk siswa tertentu.
     */
    public function show(User $student)
    {
        // Pastikan user yang diakses adalah siswa
        abort_if(!$student->isStudent(), 404);

        // Memuat jumlah jawaban secara efisien untuk ditampilkan di ringkasan
        $student->loadCount([
            'hotsActivityAnswers',
            'hotsActivityAnswers as correct_answers_count' => function ($query) {
                $query->where('is_correct', true);
            }
        ]);

        $answers = $student->hotsActivityAnswers()->with('hotsActivity.readingMaterial')->latest()->paginate(15);
        return view('admin.students.show', compact('student', 'answers'));
    }
}