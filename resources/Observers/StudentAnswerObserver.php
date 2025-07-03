<?php

namespace App\Observers;

use App\Models\HotsActivity;
use App\Models\StudentHotsActivityAnswer;
use App\Models\User;

class StudentAnswerObserver
{
    private function handleProgressUpdate(StudentHotsActivityAnswer $answer): void
    {
        $student = $answer->user;

        if ($student && !$student->isAdmin()) {
            
            $totalActivities = cache()->remember('total_activities_count', 60, function () {
                return HotsActivity::count();
            });
            
            if ($totalActivities == 0) {
                $student->progress = 0;
                $student->save();
                return;
            }

            // PERBAIKAN: Progress dihitung dari jumlah soal yang dijawab, bukan yang benar.
            $answeredActivitiesCount = $student->answers()->distinct('hots_activity_id')->count();

            $progress = ($answeredActivitiesCount / $totalActivities) * 100;

            $student->progress = round($progress);
            $student->save();
        }
    }

    public function created(StudentHotsActivityAnswer $studentHotsActivityAnswer): void
    {
        $this->handleProgressUpdate($studentHotsActivityAnswer);
    }

    public function updated(StudentHotsActivityAnswer $studentHotsActivityAnswer): void
    {
        $this->handleProgressUpdate($studentHotsActivityAnswer);
    }

    public function deleted(StudentHotsActivityAnswer $studentHotsActivityAnswer): void
    {
        $this->handleProgressUpdate($studentHotsActivityAnswer);
    }
}