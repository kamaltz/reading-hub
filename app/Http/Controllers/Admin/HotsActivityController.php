<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotsActivity;
use App\Models\ReadingMaterial; // <-- Import model induk
use Illuminate\Http\Request;

class HotsActivityController extends Controller
{
    /**
     * Menampilkan daftar semua aktivitas untuk sebuah materi spesifik.
     * Menerima $material karena route-nya nested.
     */
    public function index(ReadingMaterial $material)
    {
        // View-nya belum kita buat, ini hanya contoh logika
        return view('admin.activities.index', [
            'material' => $material,
            'activities' => $material->hotsActivities()->get()
        ]);
    }

    /**
     * Menampilkan daftar semua aktivitas dari semua materi.
     */
    public function all()
    {
        // Ambil semua aktivitas, beserta relasi ke materi induknya
        // Urutkan dari yang terbaru, dan gunakan pagination
        $activities = HotsActivity::with('readingMaterial')->latest()->paginate(15);
        return view('admin.activities.all', compact('activities'));
    }

    /**
     * Menampilkan form untuk membuat aktivitas baru untuk materi spesifik.
     * Menerima $material karena route-nya nested.
     */
    public function create(ReadingMaterial $material)
    {
        return view('admin.activities.create', compact('material'));
    }

    /**
     * Menyimpan aktivitas baru yang berelasi dengan materi spesifik.
     * Menerima $material karena route-nya nested.
     */
    public function store(Request $request, ReadingMaterial $material)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:multiple_choice,essay',
            'options' => 'nullable|array|required_if:type,multiple_choice', // 'options' wajib jika tipenya multiple_choice
            'answer_key' => 'nullable|string|required_if:type,multiple_choice',
        ]);

        // Cara elegan untuk membuat data yang berelasi
        $material->hotsActivities()->create($validated);

        return redirect()->route('admin.materials.edit', $material)->with('success', 'Aktivitas HOTS berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit aktivitas yang sudah ada.
     * Hanya menerima $activity karena route-nya sudah "shallow".
     */
    public function edit(HotsActivity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Memperbarui aktivitas yang sudah ada.
     * Hanya menerima $activity karena route-nya sudah "shallow".
     */
    public function update(Request $request, HotsActivity $activity)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'type' => 'required|in:multiple_choice,essay',
            'options' => 'nullable|array|required_if:type,multiple_choice',
            'answer_key' => 'nullable|string|required_if:type,multiple_choice',
        ]);
        
        $activity->update($validated);

        // Redirect kembali ke halaman edit materi induknya
        return redirect()->route('admin.materials.edit', $activity->reading_material_id)->with('success', 'Aktivitas HOTS berhasil diperbarui.');
    }

    /**
     * Menghapus aktivitas.
     * Hanya menerima $activity karena route-nya sudah "shallow".
     */
    public function destroy(HotsActivity $activity)
    {
        $material_id = $activity->reading_material_id; // Simpan ID induk sebelum dihapus
        $activity->delete();

        return redirect()->route('admin.materials.edit', $material_id)->with('success', 'Aktivitas HOTS berhasil dihapus.');
    }
}