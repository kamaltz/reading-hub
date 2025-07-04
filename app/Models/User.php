<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Periksa apakah pengguna adalah admin.
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Relasi ke jawaban aktivitas siswa.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(StudentHotsActivityAnswer::class);
    }
    
    /**
     * Alias untuk relasi answers (untuk backward compatibility)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentHotsActivityAnswers(): HasMany
    {
        return $this->hasMany(StudentHotsActivityAnswer::class);
    }
}