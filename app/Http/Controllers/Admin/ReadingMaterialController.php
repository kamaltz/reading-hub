<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\ReadingMaterial;
use Illuminate\Http\Request;

class ReadingMaterialController extends Controller
{
    /**
     * Menampilkan daftar semua materi bacaan.
     */
    public function index()
    {
        // Ambil semua materi, eager load relasi untuk performa,
        // dan hitung jumlah aktivitas terkait dengan withCount.
        $materials = ReadingMaterial::with(['chapter', 'genre'])
            ->withCount('activities')
            ->latest()
            ->get();

        return view('admin.materials.index', compact('materials'));
    }

    /**
     * Menampilkan form untuk membuat materi baru.
     */
    public function create()
    {
        $genres = Genre::all();
        $chapters = Chapter::all();
        return view('admin.materials.create', compact('genres', 'chapters'));
    }

    /**
     * Menyimpan materi baru.
     */
    public function store(Request $request)
    {
        // Logika untuk menyimpan materi baru
        // (Dapat Anda implementasikan sesuai kebutuhan)
        // ...

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil dibuat.');
    }

    /**
     * Menampilkan halaman detail materi beserta aktivitasnya.
     * Ini adalah halaman kunci tempat admin mengelola aktivitas.
     */
    public function show(ReadingMaterial $material)
    {
        // Eager load relasi activities untuk ditampilkan di view.
        $material->load('activities');
        return view('admin.materials.show', compact('material'));
    }

    /**
     * Menampilkan form untuk mengedit materi.
     */
    public function edit(ReadingMaterial $material)
    {
        $genres = Genre::all();
        $chapters = Chapter::all();
        return view('admin.materials.edit', compact('material', 'genres', 'chapters'));
    }

    /**
     * Memperbarui materi yang ada.
     */
    public function update(Request $request, ReadingMaterial $material)
    {
        // Logika untuk memperbarui materi
        // (Dapat Anda implementasikan sesuai kebutuhan)
        // ...

        return redirect()->route('admin.materials.index')->with('success', 'Materi berhasil diperbarui.');
    }
}