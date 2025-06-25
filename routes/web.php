<?php

// Semua 'use' statement dikumpulkan di atas agar rapi
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\StudentActivityController;
use App\Http\Controllers\Admin\HotsActivityController;
use App\Http\Controllers\Admin\StudentProgressController;
use App\Http\Controllers\Admin\ReadingMaterialController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\ReadingMaterial;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == HALAMAN PUBLIK ==
Route::get('/', [HomepageController::class, 'index'])->name('home');

// == HALAMAN PENGGUNA TERAUTENTIKASI (SISWA/ADMIN) ==
Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rute khusus siswa
    // PERBAIKAN: Mengarahkan ke view 'materials.show' yang sudah ada
    Route::get('/materials/{readingMaterial}', function (ReadingMaterial $readingMaterial) {
        $readingMaterial->load('activities');
        return view('materials.show', ['material' => $readingMaterial]);
    })->name('materials.show');
    
    Route::get('/activities', [StudentActivityController::class, 'index'])->name('student.activities.index');
    Route::post('/activities/{activity}/answer', [StudentActivityController::class, 'store'])->name('activities.answer');
});


// == HALAMAN ADMIN / CONTENT MANAGER ==
Route::prefix('admin')
    ->middleware(['auth', AdminMiddleware::class])
    ->name('admin.')
    ->group(function () {
        
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');        
        Route::resource('materials', ReadingMaterialController::class);
        Route::resource('genres', GenreController::class);
        Route::resource('chapters', ChapterController::class);
        
        Route::get('activities', [HotsActivityController::class, 'all'])->name('activities.all');
        // Nested routes for activities under a specific material
        Route::get('/materials/{material}/activities/create', [HotsActivityController::class, 'create'])->name('activities.create');
        Route::post('/materials/{material}/activities', [HotsActivityController::class, 'store'])->name('activities.store');
        
        Route::resource('students', StudentProgressController::class)->only(['index', 'show']);

        // Routes for editing, updating, and deleting a specific activity
        Route::get('activities/{activity}/edit', [HotsActivityController::class, 'edit'])->name('activities.edit');
        Route::put('activities/{activity}', [HotsActivityController::class, 'update'])->name('activities.update');
        Route::delete('activities/{activity}', [HotsActivityController::class, 'destroy'])->name('activities.destroy');
    });

require __DIR__.'/auth.php';