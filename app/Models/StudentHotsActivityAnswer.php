<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHotsActivityAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hots_activity_id',
        'student_answer',
        'is_correct',
        'score',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotsActivity()
    {
        // The related model is now Activity. We must explicitly define the foreign key
        // 'hots_activity_id' because it no longer matches Laravel's convention for an 'Activity' model.
        return $this->belongsTo(Activity::class, 'hots_activity_id');
    }
}