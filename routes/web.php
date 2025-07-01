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
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// == HALAMAN PUBLIK ==
Route::get('/', [HomepageController::class, 'index']);

// == HALAMAN PENGGUNA TERAUTENTIKASI (SISWA/ADMIN) ==
Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::post('activities/{activity}/duplicate', [HotsActivityController::class, 'duplicate'])->name('activities.duplicate');


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
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
        
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('materials', ReadingMaterialController::class);
        Route::resource('genres', GenreController::class);
        Route::resource('chapters', ChapterController::class);
        
        // Rute Manajemen Siswa yang Baru dan Lengkap
        Route::get('students/import', [StudentController::class, 'importForm'])->name('students.import.form');
        Route::get('students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
        Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
        Route::resource('students', StudentController::class);
        
         Route::get('activities', [HotsActivityController::class, 'all'])->name('activities.all');
        
        // Rute untuk membuat aktivitas baru di bawah materi tertentu
        Route::get('/activities/create', [HotsActivityController::class, 'create'])->name('activities.create');

        // Rute lainnya untuk aktivitas
        Route::post('/activities', [HotsActivityController::class, 'store'])->name('activities.store');
        Route::get('activities/{activity}/edit', [HotsActivityController::class, 'edit'])->name('activities.edit');
        Route::put('activities/{activity}', [HotsActivityController::class, 'update'])->name('activities.update');
        Route::delete('activities/{activity}', [HotsActivityController::class, 'destroy'])->name('activities.destroy');
        Route::post('activities/{activity}/duplicate', [HotsActivityController::class, 'duplicate'])->name('activities.duplicate');
        Route::post('activities/reorder', [HotsActivityController::class, 'reorder'])->name('activities.reorder');
    });

    // Rute untuk maintenance (hanya untuk development)
    // Akses dari browser: http://your-app.test/clear-all-cache
    Route::get('/clear-all-cache', function () {
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        return "Cache aplikasi (view, route, config) berhasil dibersihkan!";
    });

    // Tambahkan kode ini di paling bawah
Route::get('/test-user-model', function () {
    // Ambil user pertama (atau user yang sedang login)
    $user = \App\Models\User::first();

    if (!$user) {
        return 'Tidak ada user di database.';
    }

    // Tes fungsi isAdmin()
    $isAdminExists = method_exists($user, 'isAdmin');
    echo 'Fungsi isAdmin() ada? ' . ($isAdminExists ? 'YA' : 'TIDAK') . '<br>';

    // Tes fungsi answers()
    $answersExists = method_exists($user, 'answers');
    echo 'Fungsi answers() ada? ' . ($answersExists ? 'YA' : 'TIDAK') . '<br>';
});



require __DIR__.'/auth.php';