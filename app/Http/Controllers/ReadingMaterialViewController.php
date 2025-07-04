<?php

namespace App\Http\Controllers;

use App\Models\ReadingMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReadingMaterialViewController extends Controller
{
    /**
     * Menampilkan detail materi bacaan beserta aktivitasnya.
     */
    public function show(ReadingMaterial $material): View
    {
        // Eager load aktivitas untuk mencegah N+1 query
        $material->load('activities');
        
        return view('materials.show', compact('material'));
    }
}