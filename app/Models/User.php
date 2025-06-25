<?php

namespace App\Models;

use App\Models\StudentHotsActivityAnswer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mengecek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Mendefinisikan relasi bahwa seorang User memiliki banyak Jawaban Aktivitas HOTS.
     */
    public function answers(): HasMany
    {
        // PERBAIKAN: Menggunakan foreign key 'user_id' yang benar sesuai standar Laravel.
        // Laravel secara otomatis akan mencari kolom 'user_id' jika parameter kedua dikosongkan.
        return $this->hasMany(StudentHotsActivityAnswer::class);
    }
}