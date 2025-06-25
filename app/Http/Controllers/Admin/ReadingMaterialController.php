<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReadingMaterial;
use App\Models\Chapter;
use App\Models\Genre;
use Illuminate\Http\Request;

class ReadingMaterialController extends Controller
{
    /**
     * Menampilkan daftar semua materi.
     */
    public function index()
    {
        $materials = ReadingMaterial::with('chapter', 'genre')->latest()->paginate(10);
        return view('admin.materials.index', compact('materials'));
    }

    /**
     * Menampilkan form untuk membuat materi baru.
     */
    public function create()
    {
        $chapters = Chapter::orderBy('title')->get();
        $genres = Genre::orderBy('name')->get();
        return view('admin.materials.create', compact('chapters', 'genres'));
    }

    /**
     * Menyimpan materi baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'chapter_id' => 'required|exists:chapters,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        ReadingMaterial::create($validated);

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu materi beserta aktivitasnya.
     */
    public function show(ReadingMaterial $material)
    {
        // Memuat relasi 'activities' agar bisa ditampilkan di view
        $material->load('activities');
        return view('admin.materials.show', compact('material'));
    }

    /**
     * Menampilkan form untuk mengedit materi.
     */
    public function edit(ReadingMaterial $material)
    {
        $chapters = Chapter::orderBy('title')->get();
        $genres = Genre::orderBy('name')->get();

        // PERBAIKAN: Memuat relasi 'activities' untuk mencegah error di view
        $material->load('activities');

        return view('admin.materials.edit', compact('material', 'chapters', 'genres'));
    }

    /**
     * Memperbarui materi di database.
     */
    public function update(Request $request, ReadingMaterial $material)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'chapter_id' => 'required|exists:chapters,id',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $material->update($validated);

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Menghapus materi dari database.
     */
    public function destroy(ReadingMaterial $material)
    {
        // Sebaiknya tambahkan juga logika untuk menghapus aktivitas terkait
        // atau menangani relasi sebelum menghapus materi.
        $material->delete();
        
        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil dihapus.');
    }
}