<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard khusus untuk siswa.
     */
    public function __invoke(Request $request)
    {
        // Ambil semua chapter. Atribut 'progress' akan otomatis dihitung
        // oleh accessor yang sudah kita buat di model Chapter.
        $chapters = Chapter::with('activities')->get();

        // Tidak ada lagi pengecekan role. Controller ini murni untuk siswa.
        // Kirim data ke komponen React 'Dashboard.jsx'
        return Inertia::render('Dashboard', [
            'chapters' => $chapters,
        ]);
    }
}