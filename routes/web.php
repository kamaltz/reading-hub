<?php

// Semua 'use' statement dikumpulkan di atas agar rapi
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentActivityController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\HotsActivityController;
use App\Http\Controllers\Admin\ReadingMaterialController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\ReadingMaterial;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web".
|
*/

// == HALAMAN PUBLIK ==
Route::get('/', [HomepageController::class, 'index'])->name('welcome');


// == HALAMAN PENGGUNA TERAUTENTIKASI (SISWA & ADMIN) ==
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rute khusus siswa untuk melihat materi dan mengerjakan aktivitas
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
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
        
        Route::resource('materials', ReadingMaterialController::class);
        Route::post('materials/upload-image', [ReadingMaterialController::class, 'uploadImage'])->name('materials.upload-image');
        Route::resource('genres', GenreController::class);
        Route::resource('chapters', ChapterController::class);
        
        // --- Rute Manajemen Siswa ---
        // Rute spesifik harus didefinisikan SEBELUM route resource
        Route::get('students/generate', [StudentController::class, 'showGenerateForm'])->name('students.generate');
        Route::post('students/generate', [StudentController::class, 'storeGenerated'])->name('students.generate.store');
        Route::get('students/import', [StudentController::class, 'importForm'])->name('students.import.form');
        Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
        Route::get('students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
        Route::resource('students', StudentController::class);
        
        // --- Rute Manajemen Aktivitas ---
        Route::get('activities', [HotsActivityController::class, 'all'])->name('activities.all');
        Route::get('activities/create', [HotsActivityController::class, 'create'])->name('activities.create');
        Route::post('activities', [HotsActivityController::class, 'store'])->name('activities.store');
        Route::get('activities/{activity}/edit', [HotsActivityController::class, 'edit'])->name('activities.edit');
        Route::put('activities/{activity}', [HotsActivityController::class, 'update'])->name('activities.update');
        Route::delete('activities/{activity}', [HotsActivityController::class, 'destroy'])->name('activities.destroy');
        Route::post('activities/{activity}/duplicate', [HotsActivityController::class, 'duplicate'])->name('activities.duplicate');
        Route::post('activities/reorder', [HotsActivityController::class, 'reorder'])->name('activities.reorder');
    });

// Rute untuk otentikasi (login, register, dll.)
require __DIR__.'/auth.php';


// == RUTE UNTUK DEVELOPMENT (JANGAN DIGUNAKAN DI PRODUKSI) ==
if (app()->isLocal()) {
    // Akses dari browser: http://your-app.test/clear-all-cache
    Route::get('/clear-all-cache', function () {
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        return "Cache aplikasi (view, route, config, data) berhasil dibersihkan!";
    });

    // Rute untuk mengetes relasi dan fungsi pada model User
    Route::get('/test-user-model', function () {
        $user = \App\Models\User::first();

        if (!$user) {
            return 'Tidak ada user di database.';
        }

        $isAdminExists = method_exists($user, 'isAdmin');
        $answersExists = method_exists($user, 'answers');

        return response()->json([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'fungsi_isAdmin_ada' => $isAdminExists,
            'hasil_isAdmin' => $isAdminExists ? $user->isAdmin() : 'N/A',
            'fungsi_answers_ada' => $answersExists,
            'jumlah_jawaban' => $answersExists ? $user->answers()->count() : 'N/A',
        ]);
    });
}