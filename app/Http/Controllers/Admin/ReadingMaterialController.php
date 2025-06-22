<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReadingMaterial;
use App\Models\Chapter;
use App\Models\Genre;
use Illuminate\Http\Request;

class ReadingMaterialController extends Controller
{
    // Menampilkan daftar semua materi
    public function index()
    {
        $materials = ReadingMaterial::with('chapter', 'genre')->latest()->get();
        return view('admin.materials.index', compact('materials'));
    }

    // Menampilkan form untuk membuat materi baru
    public function create()
    {
        $chapters = Chapter::all();
        $genres = Genre::all();
        return view('admin.materials.create', compact('chapters', 'genres'));
    }

    // Menyimpan materi baru ke database
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'chapter_id' => 'required|exists:chapters,id',
        'genre_id' => 'required|exists:genres,id',
        'illustration' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
    ]);

    if ($request->hasFile('illustration')) {
        // Simpan gambar dan dapatkan path-nya
        $path = $request->file('illustration')->store('illustrations', 'public');
        $validated['illustration_path'] = $path;
    }

    ReadingMaterial::create($validated);

    return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil ditambahkan.');
}

    // Menampilkan form untuk mengedit materi
    public function edit(ReadingMaterial $material)
    {
        $chapters = Chapter::all();
        $genres = Genre::all();
        return view('admin.materials.edit', compact('material', 'chapters', 'genres'));
    }

    // Memperbarui materi di database
    public function update(Request $request, ReadingMaterial $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'chapter_id' => 'required|exists:chapters,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $material->update($request->all());

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil diperbarui.');
    }

    // Menghapus materi dari database
    public function destroy(ReadingMaterial $material)
    {
        $material->delete();
        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil dihapus.');
    }
}