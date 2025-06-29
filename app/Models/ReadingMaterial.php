<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadingMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'chapter_id',
        'genre_id',
        'illustration_path',
    ];

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Relasi ke model HotsActivity (satu materi punya banyak aktivitas).
     */
    public function activities()
    {
        // The 'hots_activities' table was refactored to use 'chapter_id'
        // instead of 'reading_material_id'. This relationship now correctly
        // links activities that share the same chapter.
        return $this->hasMany(Activity::class, 'chapter_id', 'chapter_id');
    }
}