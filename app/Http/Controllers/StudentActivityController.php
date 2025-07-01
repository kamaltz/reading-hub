<?php

namespace App\Http\Controllers;

use App\Models\HotsActivity;
use App\Models\StudentHotsActivityAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentActivityController extends Controller
{
    /**
     * Menampilkan daftar aktivitas yang telah dijawab oleh siswa.
     */
    public function index()
    {
        $user = Auth::user();
        // Asumsi relasi 'answers' ada di model User
        $answers = $user->answers()->with('activity.readingMaterial')->paginate(10);
        return view('students.activities.index', compact('answers'));
    }

    /**
     * Menyimpan jawaban siswa untuk sebuah aktivitas.
     * INI ADALAH METODE YANG HILANG.
     */
    public function store(Request $request, HotsActivity $activity)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $user = Auth::user();

        // Gunakan updateOrCreate untuk menyimpan atau memperbarui jawaban.
        // Ini mencegah siswa mengirim jawaban ganda untuk aktivitas yang sama.
        StudentHotsActivityAnswer::updateOrCreate(
            [
                'user_id' => $user->id,
                'hots_activity_id' => $activity->id,
            ],
            [
                'answer' => $request->input('answer'),
            ]
        );

        // Kembali ke halaman materi setelah menjawab
        return redirect()->route('materials.show', $activity->reading_material_id)
                         ->with('success', 'Jawaban Anda berhasil disimpan!');
    }
}