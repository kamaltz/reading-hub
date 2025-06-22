<?php
// app/Http/Controllers/ReadingMaterialViewController.php
namespace App\Http\Controllers;

use App\Models\ReadingMaterial;

class ReadingMaterialViewController extends Controller
{
    public function show(ReadingMaterial $material)
{
    // Sekarang kita load juga relasi activities
    $material->load('chapter', 'genre', 'hotsActivities');

    return view('materials.show', compact('material'));
}
}