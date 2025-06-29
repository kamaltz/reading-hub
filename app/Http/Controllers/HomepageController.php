<?php

namespace App\Http\Controllers;

use App\Models\ReadingMaterial;
use App\Models\User;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    /**
     * Menampilkan landing page dengan data statistik.
     */
    public function index()
    {
        // Ambil data statistik untuk ditampilkan di landing page
        $studentCount = User::where('role', 'student')->count();
        $materialCount = ReadingMaterial::count();

        // Kirim data ke view
        return view('welcome', [
            'studentCount' => $studentCount,
            'materialCount' => $materialCount,
        ]);
    }
}