<?php

// Semua 'use' statement dikumpulkan di atas agar rapi
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReadingMaterialViewController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\StudentActivityController;
use App\Http\Controllers\Admin\HotsActivityController;
use App\Http\Controllers\Admin\StudentProgressController;
use App\Http\Controllers\Admin\ReadingMaterialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda bisa mendaftarkan route untuk aplikasi web Anda.
|
*/

// == HALAMAN PUBLIK / UNTUK SISWA ==
Route::get('/', [HomepageController::class, 'index'])->name('home');

// == HALAMAN PENGGUNA TERAUTENTIKASI (SISWA/USER BIASA) ==
// Route dashboard sekarang akan memanggil DashboardController@index
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route untuk menampilkan detail materi (hanya untuk user yang sudah login)
    Route::get('/materials/{material}', [ReadingMaterialViewController::class, 'show'])->name('materials.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk siswa mengirimkan jawaban aktivitas
    Route::post('/activities/{activity}/answer', [StudentActivityController::class, 'store'])->name('activities.answer');
});


// == HALAMAN ADMIN / CONTENT MANAGER ==
// Semua route di sini akan memiliki prefix '/admin' dan nama 'admin.'
// Contoh: URL /admin/materials akan memiliki nama route 'admin.materials.index'
Route::prefix('admin')
    ->middleware(['auth', 'admin']) // Pastikan hanya user admin yang bisa akses
    ->name('admin.')
    ->group(function () {
        
        // Route untuk mengelola Materi Bacaan
        Route::resource('materials', ReadingMaterialController::class);

        // Route untuk mengelola Genre
        Route::resource('genres', GenreController::class);

        // Route untuk mengelola Bab
        Route::resource('chapters', ChapterController::class);

        // Route untuk mengelola Aktivitas HOTS (Nested & Shallow)
        // Diletakkan di sini karena merupakan bagian dari manajemen admin
        Route::resource('materials.activities', HotsActivityController::class)->shallow();

        // Route untuk melihat semua aktivitas secara global
        Route::get('activities', [HotsActivityController::class, 'all'])->name('activities.all');

        // Route untuk memonitoring progres siswa
        Route::resource('students', StudentProgressController::class)->only(['index', 'show']);

    });


// File ini berisi route untuk otentikasi (login, register, dll)
require __DIR__.'/auth.php';