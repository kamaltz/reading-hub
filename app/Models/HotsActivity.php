<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotsActivity extends Model
{
protected $fillable = ['reading_material_id', 'question', 'type', 'options', 'answer_key'];
protected $casts = ['options' => 'array']; // Otomatis cast JSON ke array

public function readingMaterial()
{
    return $this->belongsTo(ReadingMaterial::class);
}
}