<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
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
     * Relasi untuk menghitung aktivitas yang sudah diselesaikan oleh user yang sedang login.
     * Relasi ini dirancang untuk digunakan dengan withCount() untuk performa optimal.
     */
    public function completedActivitiesForCurrentUser(): HasMany
    {
        return $this->activities()
            ->whereHas('attempts', function ($query) {
                // Pastikan model ActivityAttempt dan kolomnya sudah sesuai
                $query->where('user_id', Auth::id())
                      ->where('status', 'completed');
            });
    }


    /**
     * Accessor dinamis untuk menghitung progres penyelesaian chapter.
     * Atribut ini akan tersedia secara otomatis sebagai $chapter->progress.
     *
     * @return float
     */
    public function getProgressAttribute(): float
    {
        // Accessor ini sekarang mengandalkan eager-loaded counts untuk performa.
        // Jika count tidak di-load sebelumnya, ia akan menjadi 0.
        // Ini mendorong praktik yang baik untuk selalu melakukan eager-load.
        $totalActivitiesCount = $this->activities_count ?? 0;

        if ($totalActivitiesCount === 0) {
            return 0;
        }

        $completedActivitiesCount = $this->completed_activities_for_current_user_count ?? 0;

        // Hitung persentase progres
        return ($completedActivitiesCount / $totalActivitiesCount) * 100;
    }
}