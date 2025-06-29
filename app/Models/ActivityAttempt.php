<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Nama class diubah menjadi ActivityAttempt untuk konsistensi dan kejelasan.
// Nama tabel bisa didefinisikan secara eksplisit jika tidak mengikuti konvensi Laravel.
class ActivityAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hots_activity_id',
        'student_answer',
        'is_correct',
        'score',
        'status', // Tambahkan 'status' agar konsisten dengan query di Chapter->getProgressAttribute()
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        // The related model is now Activity. We must explicitly define the foreign key
        // 'hots_activity_id' because it no longer matches Laravel's convention for an 'Activity' model.
        return $this->belongsTo(Activity::class, 'hots_activity_id');
    }
}