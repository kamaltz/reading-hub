<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentActivityController;
use App\Models\ReadingMaterial;
use Illuminate\Support\Facades\Route;

// === USE STATEMENTS UNTUK ADMIN ===
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\HotsActivityController;
use App\Http\Controllers\Admin\ReadingMaterialController;
use App\Http\Controllers\Admin\StudentProgressController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomepageController::class, 'index'])->name('home');

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
    Route::get('/materials/{readingMaterial}', function (ReadingMaterial $readingMaterial) {
        $readingMaterial->load('activities');
        return view('student.materials.show', ['material' => $readingMaterial]);
    })->name('student.materials.show');

    Route::get('/activities', [StudentActivityController::class, 'index'])->name('student.activities.index');
});


require __DIR__.'/auth.php';


// ADMIN ROUTES
Route::prefix('admin')
    ->middleware(['auth', AdminMiddleware::class])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Reading Materials
        Route::resource('/materials', ReadingMaterialController::class);

        // Genres
        Route::resource('/genres', GenreController::class)->except(['edit', 'update', 'show']);

        // Chapters
        Route::resource('/chapters', ChapterController::class)->except(['show']);

        // Hots Activities
        Route::prefix('activities')->name('activities.')->group(function () {
            Route::get('/', [HotsActivityController::class, 'all'])->name('all');
            Route::get('/create/{materialId}', [HotsActivityController::class, 'create'])->name('create');
            Route::post('/', [HotsActivityController::class, 'store'])->name('store');
        });
        
        // Student Progress
        Route::resource('/students', StudentProgressController::class)->only(['index', 'show']);
    });