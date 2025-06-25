<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// PERBAIKAN: Menambahkan 'use' statement untuk model yang direferensikan.
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\HotsActivity;

class ReadingMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'chapter_id',
        'genre_id',
    ];

    /**
     * Relasi ke model Chapter.
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Relasi ke model Genre.
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Relasi ke model HotsActivity.
     */
    public function activities(): HasMany
    {
        return $this->hasMany(HotsActivity::class, 'reading_material_id');
    }
}