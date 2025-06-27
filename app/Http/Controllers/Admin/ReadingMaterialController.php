<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReadingMaterial;
use App\Models\Chapter;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // # PERBAIKAN: Tambahkan baris ini

class ReadingMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = ReadingMaterial::with(['chapter', 'genre'])->latest()->paginate(10);
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
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'chapter_id' => 'required|exists:chapters,id',
            'genre_id' => 'required|exists:genres,id',
            'illustration' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $illustrationPath = null;
        if ($request->hasFile('illustration')) {
            $illustrationPath = $request->file('illustration')->store('illustrations', 'public');
        }

        ReadingMaterial::create([
            'title' => $request->title,
            'content' => $request->content,
            'chapter_id' => $request->chapter_id,
            'genre_id' => $request->genre_id,
            'illustration_path' => $illustrationPath,
        ]);

        return redirect()->route('admin.materials.index')->with('success', 'Reading material created successfully.');
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
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'chapter_id' => 'required|exists:chapters,id',
            'genre_id' => 'required|exists:genres,id',
            'illustration' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $illustrationPath = $material->illustration_path;
        if ($request->hasFile('illustration')) {
            // Hapus gambar lama jika ada
            if ($illustrationPath) {
                Storage::disk('public')->delete($illustrationPath);
            }
            $illustrationPath = $request->file('illustration')->store('illustrations', 'public');
        }

        $material->update([
            'title' => $request->title,
            'content' => $request->content,
            'chapter_id' => $request->chapter_id,
            'genre_id' => $request->genre_id,
            'illustration_path' => $illustrationPath,
        ]);

        return redirect()->route('admin.materials.index')->with('success', 'Reading material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReadingMaterial $material)
    {
        // Hapus semua aktivitas yang terkait dengan materi ini
        $material->activities()->delete();

        // Hapus file ilustrasi jika ada
        if ($material->illustration_path) {
            Storage::disk('public')->delete($material->illustration_path);
        }

        // Hapus materi itu sendiri
        $material->delete();

        return redirect()->route('admin.materials.index')->with('success', 'Reading material and its activities deleted successfully.');
    }
}