<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReadingMaterial;
use App\Models\Chapter;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReadingMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = ReadingMaterial::with('chapter', 'genre')->latest()->paginate(10);
        return view('admin.materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $chapters = Chapter::all();
        $genres = Genre::all();
        return view('admin.materials.create', compact('chapters', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'chapter_id' => 'required|exists:chapters,id',
            'genre_id' => 'required|exists:genres,id',
            'illustration' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('illustration')) {
            $validated['illustration'] = $request->file('illustration')->store('illustrations', 'public');
        }

        ReadingMaterial::create($validated);

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReadingMaterial $material)
    {
        $material->load('activities');
        return view('admin.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReadingMaterial $material)
    {
        $chapters = Chapter::all();
        $genres = Genre::all();
        return view('admin.materials.edit', compact('material', 'chapters', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReadingMaterial $material)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'chapter_id' => 'required|exists:chapters,id',
            'genre_id' => 'required|exists:genres,id',
            'illustration' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('illustration')) {
            if ($material->illustration) {
                Storage::disk('public')->delete($material->illustration);
            }
            $validated['illustration'] = $request->file('illustration')->store('illustrations', 'public');
        }

        $material->update($validated);

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReadingMaterial $material)
    {
        if ($material->illustration) {
            Storage::disk('public')->delete($material->illustration);
        }
        $material->delete();
        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil dihapus.');
    }

    /**
     * Handle image upload for TinyMCE editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $path = $request->file('file')->store('editor-images', 'public');
        $url = asset('storage/' . $path);

        return response()->json(['location' => $url]);
    }
}