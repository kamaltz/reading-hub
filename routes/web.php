<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; // Controller untuk Siswa
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController; // Controller untuk Admin (gunakan alias 'as' untuk menghindari konflik nama)
use App\Http\Controllers\Admin\ActivityController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Rute untuk user yang sudah login (Siswa)
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])->name('dashboard');

// Grup Rute untuk Admin
Route::middleware(['auth', 'verified' /*, 'role:admin' */])->prefix('admin')->name('admin.')->group(function () {
    // URL /admin/dashboard akan memanggil AdminDashboardController
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

    // Rute untuk manajemen aktivitas
    Route::resource('activities', ActivityController::class);

    // Rute untuk manajemen genre
    Route::resource('genres', GenreController::class);

    // Tambahkan rute admin lainnya di sini...
});


// Rute Profil (bisa diakses oleh semua role yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';