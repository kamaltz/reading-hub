<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'genre_id'];

    /**
     * INI ADALAH FUNGSI YANG HILANG
     * Mendefinisikan bahwa Chapter ini milik satu Genre.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Mendefinisikan bahwa Chapter memiliki banyak ReadingMaterial.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function readingMaterials(): HasMany
    {
        return $this->hasMany(ReadingMaterial::class);
    }

    /**
     * Mendapatkan semua aktivitas (HotsActivity) di dalam sebuah chapter
     * melalui ReadingMaterial.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function activities(): HasManyThrough
    {
        return $this->hasManyThrough(HotsActivity::class, ReadingMaterial::class);
    }
}