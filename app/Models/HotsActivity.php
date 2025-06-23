<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotsActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['question', 'type', 'options', 'answer_key', 'answer', 'sequence'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'json', // Pastikan 'options' selalu di-handle sebagai JSON/array
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model ReadingMaterial.
     */
    public function readingMaterial()
    {
        return $this->belongsTo(\App\Models\ReadingMaterial::class);
    }
}