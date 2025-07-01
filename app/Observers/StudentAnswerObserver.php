<?php

namespace App\Observers;

use App\Models\HotsActivity;
use App\Models\StudentHotsActivityAnswer;
use App\Models\User;

class StudentAnswerObserver
{
    /**
     * Menangani event "created" dan "updated" pada model StudentHotsActivityAnswer.
     * Fungsi ini akan menghitung ulang progress belajar siswa.
     *
     * @param  \App\Models\StudentHotsActivityAnswer  $answer
     * @return void
     */
    private function handleProgressUpdate(StudentHotsActivityAnswer $answer): void
    {
        // 1. Ambil data siswa dari jawaban yang baru disimpan
        $student = $answer->user;

        // 2. Pastikan user yang terkait adalah seorang siswa (bukan admin)
        if ($student && !$student->isAdmin()) {
            
            // 3. Hitung total semua aktivitas yang ada di sistem
            // Kita cache query ini agar tidak terlalu sering query ke DB jika banyak jawaban masuk bersamaan
            $totalActivities = cache()->remember('total_activities_count', 60, function () {
                return HotsActivity::count();
            });
            
            // 4. Jika tidak ada aktivitas sama sekali, set progress ke 0 untuk menghindari error pembagian
            if ($totalActivities == 0) {
                $student->progress = 0;
                $student->save();
                return;
            }

            // 5. Hitung berapa banyak aktivitas unik yang sudah dijawab oleh siswa ini
            $answeredActivitiesCount = $student->answers()->count();

            // 6. Hitung persentase progress
            $progress = ($answeredActivitiesCount / $totalActivities) * 100;

            // 7. Simpan nilai progress yang sudah dibulatkan ke database user
            $student->progress = round($progress);
            $student->save();
        }
    }

    /**
     * Handle the StudentHotsActivityAnswer "created" event.
     *
     * @param  \App\Models\StudentHotsActivityAnswer  $studentHotsActivityAnswer
     * @return void
     */
    public function created(StudentHotsActivityAnswer $studentHotsActivityAnswer): void
    {
        // Panggil fungsi utama saat jawaban baru dibuat
        $this->handleProgressUpdate($studentHotsActivityAnswer);
    }

    /**
     * Handle the StudentHotsActivityAnswer "updated" event.
     *
     * @param  \App\Models\StudentHotsActivityAnswer  $studentHotsActivityAnswer
     * @return void
     */
    public function updated(StudentHotsActivityAnswer $studentHotsActivityAnswer): void
    {
        // Panggil fungsi utama saat jawaban diperbarui
        $this->handleProgressUpdate($studentHotsActivityAnswer);
    }

    /**
     * Handle the StudentHotsActivityAnswer "deleted" event.
     * Jika jawaban dihapus, progress juga harus dihitung ulang.
     *
     * @param  \App\Models\StudentHotsActivityAnswer  $studentHotsActivityAnswer
     * @return void
     */
    public function deleted(StudentHotsActivityAnswer $studentHotsActivityAnswer): void
    {
        // Panggil fungsi utama saat jawaban dihapus
        $this->handleProgressUpdate($studentHotsActivityAnswer);
    }
}