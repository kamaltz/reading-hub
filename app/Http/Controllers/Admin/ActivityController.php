<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity; // Menggunakan model Activity yang sudah disiapkan
use App\Models\Chapter;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ActivityController extends Controller
{
    /**
     * Menampilkan daftar semua aktivitas.
     */
    public function index()
{
    $activities = Activity::with('chapter')->withCount('questions')->latest()->paginate(10);
    return Inertia::render('Admin/Activities/Index', ['activities' => $activities]);
}

    /**
     * Menampilkan form untuk membuat aktivitas baru.
     */
    public function create()
    {
        $chapters = Chapter::all(['id', 'title']);
        return Inertia::render('Admin/Activities/Create', ['chapters' => $chapters]);
    }

    /**
     * Menyimpan aktivitas baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'chapter_id' => 'required|exists:chapters,id',
            'description' => 'nullable|string',
        ]);

        $activity = Activity::create($request->all());

        // Redirect ke halaman editor soal untuk aktivitas yang baru dibuat
        return redirect()->route('admin.activities.edit', $activity->id)
                         ->with('success', 'Aktivitas berhasil dibuat. Silakan tambahkan soal.');
    }

    /**
     * Menampilkan halaman editor untuk aktivitas yang ada.
     */
    public function edit(Activity $activity)
    {
        // Memuat aktivitas beserta relasi soal dan pilihan jawabannya
        $activity->load('questions.options');

        // Mengirim data ke komponen React melalui Inertia
        return Inertia::render('Admin/Activities/Edit', [
            'activity' => $activity
        ]);
    }

    /**
     * Memperbarui data aktivitas dan soal-soalnya.
     * Ini adalah metode yang kompleks karena menangani sinkronisasi data dari frontend.
     */
    public function update(Request $request, Activity $activity)
    {
        // 1. Validasi data dasar aktivitas
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 2. Validasi data soal dan pilihan (data array)
            'questions' => 'present|array',
            'questions.*.id' => 'nullable', // Bisa ID yang sudah ada atau null untuk soal baru
            'questions.*.content' => 'required|string',
            'questions.*.type' => 'required|string|in:multiple_choice,essay,multiple_response,true_false,matching,fill_in_the_blank',
            'questions.*.order' => 'required|integer',
            'questions.*.options' => 'present|array',
            'questions.*.options.*.id' => 'nullable',
            'questions.*.options.*.content' => 'required|string',
            'questions.*.options.*.is_correct' => 'required|boolean',
        ]);

        // Memulai transaksi database untuk memastikan integritas data
        DB::transaction(function () use ($request, $activity) {
            // Perbarui detail dasar dari aktivitas
            $activity->update($request->only('title', 'description'));

            $incomingQuestions = $request->questions;
            $existingQuestionIds = $activity->questions->pluck('id')->toArray();
            $incomingQuestionIds = collect($incomingQuestions)->pluck('id')->filter()->toArray();

            // Hapus soal yang tidak ada di data yang masuk
            $questionsToDelete = array_diff($existingQuestionIds, $incomingQuestionIds);
            Question::destroy($questionsToDelete);

            // Perbarui atau buat soal baru
            foreach ($incomingQuestions as $questionData) {
                $question = $activity->questions()->updateOrCreate(
                    ['id' => $questionData['id'] ?? null], // Cari berdasarkan ID, atau buat baru jika ID null
                    [
                        'content' => $questionData['content'],
                        'type' => $questionData['type'],
                        'order' => $questionData['order'],
                    ]
                );

                // Sinkronisasi pilihan jawaban untuk soal ini
                $existingOptionIds = $question->options->pluck('id')->toArray();
                $incomingOptionIds = collect($questionData['options'])->pluck('id')->filter()->toArray();

                $optionsToDelete = array_diff($existingOptionIds, $incomingOptionIds);
                $question->options()->whereIn('id', $optionsToDelete)->delete();

                foreach ($questionData['options'] as $optionData) {
                    $question->options()->updateOrCreate(
                        ['id' => $optionData['id'] ?? null],
                        [
                            'content' => $optionData['content'],
                            'is_correct' => $optionData['is_correct'],
                            'match_content' => $optionData['match_content'] ?? null,
                        ]
                    );
                }
            }
        });

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Aktivitas berhasil diperbarui.');
    }

    /**
     * Menghapus aktivitas dari database.
     */
    public function destroy(Activity $activity)
    {
        // Menghapus aktivitas.
        // Berkat 'onDelete('cascade')' pada migrasi, semua soal, pilihan,
        // dan percobaan pengerjaan yang terkait akan ikut terhapus secara otomatis.
        $activity->delete();

        // Redirect ke halaman daftar aktivitas dengan pesan sukses
        return redirect()->route('admin.activities.index')
                         ->with('success', 'Aktivitas berhasil dihapus.');
    }
}