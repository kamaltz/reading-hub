<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = ['title', 'sequence'];

    // app/Models/Chapter.php
public function activities()
{
    return $this->hasManyThrough(HotsActivity::class, ReadingMaterial::class);
}
}