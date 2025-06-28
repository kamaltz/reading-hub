<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Nama class diubah dari HotsActivity menjadi Activity
class Activity extends Model
{
    use HasFactory;

    // Nama tabel secara eksplisit didefinisikan untuk menghindari kebingungan
    protected $table = 'hots_activities';

    protected $fillable = [
        'chapter_id',
        'title',
        'description',
        'position', // Kolom 'position' sudah ada dari migrasi lama Anda
    ];

    /**
     * Relasi ke model Chapter.
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Relasi ke model Question.
     * Soal akan diurutkan berdasarkan kolom 'order'.
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'hots_activity_id')->orderBy('order');
    }

    /**
     * Relasi ke percobaan pengerjaan oleh siswa.
     */
    public function attempts()
    {
        return $this->hasMany(ActivityAttempt::class, 'hots_activity_id');
    }
}