<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\ReadingMaterial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $materialCount = ReadingMaterial::count();
        $chapterCount = Chapter::count();
        $genreCount = Genre::count();

        return view('dashboard', compact('materialCount', 'chapterCount', 'genreCount'));
    }
}