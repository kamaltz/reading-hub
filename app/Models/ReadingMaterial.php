<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingMaterial extends Model
{
    use HasFactory;

    // Pastikan ada titik koma di akhir baris ini
    protected $fillable = ['chapter_id', 'genre_id', 'title', 'content', 'illustration_path'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function hotsActivities()
{
    return $this->hasMany(HotsActivity::class);
}
}