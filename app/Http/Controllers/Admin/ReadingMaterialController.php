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
    // Validasi input, termasuk 'content'
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

    // Simpan ke database, PASTIKAN 'content' ADA DI SINI
    ReadingMaterial::create([
        'title' => $request->title,
        'content' => $request->content, // <-- INI YANG PALING PENTING
        'chapter_id' => $request->chapter_id,
        'genre_id' => $request->genre_id,
        'illustration_path' => $illustrationPath,
    ]);

    return redirect()->route('admin.materials.index')->with('success', 'Reading material created successfully.');
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