<?php

use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\HotsActivityController;
use App\Http\Controllers\Admin\ReadingMaterialController;
use App\Http\Controllers\Admin\StudentProgressController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentActivityController;
use App\Http\Controllers\ReadingMaterialViewController;
use App\Models\ReadingMaterial; // <-- Ditambahkan
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// ... (kode route lainnya)

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ROUTES UNTUK SISWA
Route::middleware(['auth', 'verified'])->group(function () {
    // Route untuk menampilkan detail materi (diperbaiki)
    Route::get('/materials/{readingMaterial}', [ReadingMaterialViewController::class, 'show'])
        ->name('student.materials.show');

    // Route baru untuk halaman aktivitas siswa
    Route::get('/activities', [StudentActivityController::class, 'index'])->name('student.activities.index');
});


require __DIR__.'/auth.php';


// == HALAMAN ADMIN / CONTENT MANAGER ==
// Semua route di sini akan memiliki prefix '/admin' dan nama 'admin.'
// Contoh: URL /admin/materials akan memiliki nama route 'admin.materials.index'
Route::prefix('admin')
    ->middleware(['auth', AdminMiddleware::class]) // <-- Perbaikan ada di sini
    ->name('admin.')
    ->group(function () {
        
        // Route untuk mengelola Materi Bacaan
        Route::resource('materials', ReadingMaterialController::class); // <-- Ditambahkan

        // Route untuk mengelola Genre
        Route::resource('genres', GenreController::class); // <-- Ditambahkan

        // Route untuk mengelola Bab
        Route::resource('chapters', ChapterController::class); // <-- Ditambahkan

        // Route untuk mengelola Aktivitas HOTS (Nested & Shallow)
        // Diletakkan di sini karena merupakan bagian dari manajemen admin
        Route::resource('materials.activities', HotsActivityController::class)->shallow(); // <-- Ditambahkan

        // Route untuk melihat semua aktivitas secara global
        Route::get('activities', [HotsActivityController::class, 'all'])->name('activities.all'); // <-- Ditambahkan

        // Route untuk memonitoring progres siswa
        Route::resource('students', StudentProgressController::class)->only(['index', 'show']); // <-- Ditambahkan

    });