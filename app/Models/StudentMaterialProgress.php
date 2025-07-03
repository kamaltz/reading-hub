<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMaterialProgress extends Model
{
    use HasFactory;

    protected $table = 'student_material_progress';

    protected $fillable = [
        'user_id',
        'reading_material_id',
        'score',
        'total_questions',
        'correct_answers',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function readingMaterial()
    {
        return $this->belongsTo(ReadingMaterial::class);
    }
}