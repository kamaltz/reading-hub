<?php

namespace App\Http\Controllers;

use App\Models\HotsActivity;
use App\Models\StudentHotsActivityAnswer;
use App\Models\StudentMaterialProgress;
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
        $userAnswer = $request->input('answer');
        
        // Get correct answer - handle both string and array formats
        $correctAnswer = $activity->correct_answer;
        if (is_array($correctAnswer)) {
            $correctAnswer = $correctAnswer[0] ?? '';
        }
        
        // Check if answer is correct
        $isCorrect = false;
        $score = 0;
        
        if ($activity->type === 'multiple_choice') {
            // For multiple choice, compare the selected option key
            $isCorrect = trim(strtolower($userAnswer)) === trim(strtolower($correctAnswer));
        } elseif ($activity->type === 'true_false') {
            // For true/false, compare boolean values
            $userBool = $userAnswer === 'true' ? 'true' : 'false';
            $correctBool = trim(strtolower($correctAnswer)) === 'true' ? 'true' : 'false';
            $isCorrect = $userBool === $correctBool;
        } elseif ($activity->type === 'fill_in_blank') {
            // For fill in blank, check if answer matches (case insensitive)
            $userAnswerClean = trim(strtolower($userAnswer));
            $correctAnswerClean = trim(strtolower($correctAnswer));
            
            // Check exact match or if correct answer contains multiple acceptable answers
            if (strpos($correctAnswerClean, '|') !== false) {
                $acceptableAnswers = explode('|', $correctAnswerClean);
                foreach ($acceptableAnswers as $acceptable) {
                    if ($userAnswerClean === trim($acceptable)) {
                        $isCorrect = true;
                        break;
                    }
                }
            } else {
                $isCorrect = $userAnswerClean === $correctAnswerClean;
            }
        } else {
            // For essay type, mark as correct by default (manual review needed)
            $isCorrect = true;
        }
        
        $score = $isCorrect ? 100 : 0;

        // Save or update answer
        StudentHotsActivityAnswer::updateOrCreate(
            [
                'user_id' => $user->id,
                'hots_activity_id' => $activity->id,
            ],
            [
                'student_answer' => $request->input('answer'),
                'is_correct' => $isCorrect,
                'score' => $isCorrect ? 100 : 0,
            ]
        );

        $message = $isCorrect ? 
            '✅ Jawaban benar! Selamat, Anda mendapat skor 100!' : 
            '❌ Jawaban kurang tepat. Skor: 0. Coba pelajari materi lagi!';
            
        return redirect()->route('materials.show', $activity->reading_material_id)
                         ->with('success', $message);
    }

    public function progress()
    {
        $user = Auth::user();
        $materials = \App\Models\ReadingMaterial::with(['activities', 'chapter', 'genre'])->get();
        $userAnswers = $user->answers()->with('hotsActivity.readingMaterial')->get();
        
        return view('students.progress', compact('materials', 'userAnswers'));
    }

    public function recent()
    {
        $user = Auth::user();
        $recentAnswers = $user->answers()
            ->with(['hotsActivity.readingMaterial'])
            ->latest()
            ->paginate(20);
            
        return view('students.recent', compact('recentAnswers'));
    }

    public function submitMaterial(Request $request, $materialId)
    {
        try {
            $request->validate([
                'answers' => 'required|array',
                'answers.*' => 'required|string',
            ]);

            $user = Auth::user();
            $material = \App\Models\ReadingMaterial::with('activities')->findOrFail($materialId);
            $answers = $request->input('answers');
            $correctCount = 0;
            $totalCount = 0;

            foreach ($material->activities as $activity) {
                if (isset($answers[$activity->id])) {
                    $userAnswer = $answers[$activity->id];
                    $correctAnswer = $activity->correct_answer;
                    
                    if (is_array($correctAnswer)) {
                        $correctAnswer = $correctAnswer[0] ?? '';
                    }
                    
                    $isCorrect = false;
                    
                    if ($activity->type === 'multiple_choice' || $activity->type === 'image_based') {
                        $isCorrect = trim(strtoupper($userAnswer)) === trim(strtoupper($correctAnswer));
                    } elseif ($activity->type === 'true_false') {
                        $userBool = $userAnswer === 'true' ? 'true' : 'false';
                        $correctBool = trim(strtolower($correctAnswer)) === 'true' ? 'true' : 'false';
                        $isCorrect = $userBool === $correctBool;
                    } elseif ($activity->type === 'fill_in_blank') {
                        $userAnswerClean = trim(strtolower($userAnswer));
                        $correctAnswerClean = trim(strtolower($correctAnswer));
                        
                        if (strpos($correctAnswerClean, '|') !== false) {
                            $acceptableAnswers = explode('|', $correctAnswerClean);
                            foreach ($acceptableAnswers as $acceptable) {
                                if ($userAnswerClean === trim($acceptable)) {
                                    $isCorrect = true;
                                    break;
                                }
                            }
                        } else {
                            $isCorrect = $userAnswerClean === $correctAnswerClean;
                        }
                    } else {
                        $isCorrect = true;
                    }
                    
                    if ($isCorrect) {
                        $correctCount++;
                    }
                    $totalCount++;
                    
                    $answerRecord = StudentHotsActivityAnswer::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'hots_activity_id' => $activity->id,
                        ],
                        [
                            'student_answer' => $userAnswer,
                            'is_correct' => $isCorrect,
                            'score' => $isCorrect ? 100 : 0,
                        ]
                    );
                    
                    \Log::info('Answer saved: User ' . $user->id . ', Activity ' . $activity->id . ', Answer: ' . $userAnswer);
                }
            }
            
            $score = $totalCount > 0 ? round(($correctCount / $totalCount) * 100) : 0;
            
            // Save progress
            \App\Models\StudentMaterialProgress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'reading_material_id' => $materialId,
                ],
                [
                    'score' => $score,
                    'total_questions' => $totalCount,
                    'correct_answers' => $correctCount,
                    'completed_at' => now(),
                ]
            );
            
            \Log::info('Progress saved for user ' . $user->id . ' material ' . $materialId . ' score: ' . $score . ' (' . $correctCount . '/' . $totalCount . ')');
            
            return redirect()->route('materials.show', $materialId)
                             ->with('success', "✅ Materi selesai! Nilai Anda: {$score}/100 ({$correctCount}/{$totalCount} benar)");
        } catch (\Exception $e) {
            \Log::error('Submit Material Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan jawaban: ' . $e->getMessage()]);
        }
    }
}