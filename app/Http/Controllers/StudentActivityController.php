<?php

namespace App\Http\Controllers;

use App\Models\HotsActivity;
use App\Models\StudentHotsActivityAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentActivityController extends Controller
{
    /**
     * Menyimpan jawaban yang dikirim oleh siswa.
     */
    public function store(Request $request, HotsActivity $activity)
    {
        $validated = $request->validate([
            'student_answer' => 'required_without:option|nullable|string',
            'option' => 'required_without:student_answer|nullable|string',
        ]);

        $user = Auth::user();
        $isCorrect = null;
        $studentAnswer = null;

        if ($activity->type === 'multiple_choice') {
            $studentAnswer = $validated['option'];
            $isCorrect = ($studentAnswer === $activity->answer_key);
        } else { // essay
            $studentAnswer = $validated['student_answer'];
            // is_correct dibiarkan null untuk dinilai manual oleh guru
        }

        // Gunakan updateOrCreate untuk mencegah jawaban ganda dari siswa yang sama
        StudentHotsActivityAnswer::updateOrCreate(
            [
                'user_id' => $user->id,
                'hots_activity_id' => $activity->id,
            ],
            [
                'student_answer' => $studentAnswer,
                'is_correct' => $isCorrect,
            ]
        );

        return back()->with('success', 'Jawaban Anda berhasil dikirim!');
    }
}