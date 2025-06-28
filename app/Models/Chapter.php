<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'sequence'];

    /**
     * Mendefinisikan relasi "one-to-many" ke model Activity.
     * Sebuah Chapter dapat memiliki banyak Aktivitas.
     */
    public function activities(): HasMany
    {
        // Pastikan nama model (Activity::class) dan foreign key sudah benar
        // sesuai dengan struktur database Anda. Laravel akan secara otomatis
        // mengasumsikan foreign key adalah 'chapter_id'.
        return $this->hasMany(Activity::class);
    }

    /**
     * Accessor dinamis untuk menghitung progres penyelesaian chapter.
     * Atribut ini akan tersedia secara otomatis sebagai $chapter->progress.
     *
     * @return float
     */
    public function getProgressAttribute(): float
    {
        // Untuk menghindari error jika tidak ada user yang login (misalnya di seeder atau tinker)
        if (!auth()->check()) {
            return 0;
        }

        // Ambil semua ID aktivitas yang ada di dalam chapter ini
        $activityIds = $this->activities()->pluck('id');

        // Jika tidak ada aktivitas sama sekali di chapter ini, progresnya 0%
        if ($activityIds->isEmpty()) {
            return 0;
        }

        // Hitung berapa banyak aktivitas yang sudah diselesaikan oleh siswa yang sedang login
        $completedActivitiesCount = ActivityAttempt::where('user_id', auth()->id())
            ->whereIn('hots_activity_id', $activityIds)
            ->where('status', 'completed')
            ->distinct('hots_activity_id') // Penting untuk memastikan satu aktivitas tidak dihitung ganda
            ->count();

        // Total aktivitas di chapter ini
        $totalActivitiesCount = $activityIds->count();

        // Hitung persentase progres
        return ($completedActivitiesCount / $totalActivitiesCount) * 100;
    }
}