<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'hots_activity_id',
        'content',
        'type',
        'order',
    ];

    public function activity()
    {
        // Pastikan foreign key benar: 'hots_activity_id'
        return $this->belongsTo(Activity::class, 'hots_activity_id');
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}