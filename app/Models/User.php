<?php

namespace App\Models;

// Laravel Core & Relasi
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Filament
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
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
     * Tentukan apakah user bisa mengakses Filament Panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin(); // Menggunakan fungsi isAdmin() yang sudah ada
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function answers(): HasMany
    {
        return $this->hasMany(StudentHotsActivityAnswer::class);
    }
}