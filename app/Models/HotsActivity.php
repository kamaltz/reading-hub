<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotsActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reading_material_id',
        'type',
        'question',
        'options', // Pastikan 'options' ada di sini
        'correct_answer',
        'position',
    ];

    /**
     * # PERBAIKAN: Menambahkan 'casts' untuk kolom 'options'.
     * Ini akan secara otomatis mengubah array menjadi JSON saat menyimpan
     * dan JSON menjadi array saat mengambil data.
     *
     * @var array
     */
   protected $casts = [
    'options' => 'array',
    'correct_answer' => 'array', // atau 'json'
    'configuration' => 'array', // atau 'json'
];
    /**
     * Relasi ke ReadingMaterial.
     */
    public function readingMaterial(): BelongsTo
    {
        return $this->belongsTo(ReadingMaterial::class);
    }
    
    /**
     * Relasi ke jawaban siswa.
     */
    public function studentAnswers()
    {
        return $this->hasMany(StudentHotsActivityAnswer::class);
    }
}