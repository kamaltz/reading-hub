<?php

namespace App\Http\Controllers;

use App\Models\ReadingMaterial;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        // Ambil semua materi beserta relasi chapter dan genre, urutkan dari yang terbaru
        $materials = ReadingMaterial::with('chapter', 'genre')->latest()->paginate(10); // Paginate 10 item per halaman

        // Kirim data materi ke view 'welcome'
        return view('welcome', compact('materials'));
    }
}