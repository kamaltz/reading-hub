<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotsActivity;         // PERBAIKAN: Menambahkan 'use' statement
use App\Models\ReadingMaterial;     // PERBAIKAN: Menambahkan 'use' statement
use Illuminate\Http\Request;

class HotsActivityController extends Controller
{
    /**
     * Menampilkan semua aktivitas.
     */
    public function all()
    {
        // Menggunakan with() untuk eager loading agar lebih efisien
        $activities = HotsActivity::with('readingMaterial')->latest()->get();
        return view('admin.activities.all', compact('activities'));
    }

    /**
     * Menampilkan form untuk membuat aktivitas baru berdasarkan materi.
     * Menggunakan Route Model Binding untuk efisiensi dan keamanan.
     */
    public function create(ReadingMaterial $material)
    {
        // Variabel $material sudah otomatis didapat dari route model binding
        return view('admin.activities.create', compact('material'));
    }

    /**
     * Menyimpan aktivitas baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validated = $request->validate([
            'question' => 'required|string|min:5',
            'correct_answer' => 'required|string',
            'reading_material_id' => 'required|exists:reading_materials,id' // Memastikan materi ada
        ]);

        // 2. Membuat aktivitas baru menggunakan data yang sudah divalidasi
        HotsActivity::create($validated);

        // 3. Kembali ke halaman detail materi dengan pesan sukses
        return redirect()->route('admin.materials.show', $validated['reading_material_id'])
                         ->with('success', 'Aktivitas baru berhasil ditambahkan.');
    }
}