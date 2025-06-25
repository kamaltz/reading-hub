<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;

class StudentActivityController extends Controller
{
    /**
     * Menampilkan daftar aktivitas yang dikelompokkan per bab.
     */
    public function index()
    {
        // Ambil semua bab, beserta materi dan aktivitasnya menggunakan eager loading
        // untuk menghindari N+1 query problem.
        $chapters = Chapter::with(['readingMaterials.activities' => function ($query) {
            // Kita bisa menambahkan constraint di sini jika perlu,
            // misalnya hanya mengambil aktivitas yang aktif.
        }])
        ->whereHas('readingMaterials.activities') // Hanya ambil bab yang memiliki aktivitas
        ->get();

        return view('student.activities.index', compact('chapters'));
    }
}