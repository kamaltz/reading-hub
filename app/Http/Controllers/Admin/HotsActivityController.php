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
        $activities = HotsActivity::with('readingMaterial')->latest()->paginate(15);
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
    public function store(Request $request, ReadingMaterial $material)
    {
        // 1. Validasi input dari form
        $validated = $request->validate([
            'question' => 'required|string|min:10',
            'type' => 'required|in:essay,multiple_choice',
            // Opsi hanya wajib jika tipe adalah pilihan ganda
            'options' => 'required_if:type,multiple_choice|array|size:4',
            'options.*' => 'required_if:type,multiple_choice|string|max:255',
            // Kunci jawaban hanya wajib jika tipe adalah pilihan ganda
            'answer_key' => 'required_if:type,multiple_choice|in:A,B,C,D',
        ]);

        // 2. Menyiapkan data untuk disimpan
        $data = [
            'reading_material_id' => $material->id,
            'question' => $validated['question'],
            'type' => $validated['type'],
            'options' => null,
            'answer_key' => null,
        ];

        if ($validated['type'] === 'multiple_choice') {
            $data['options'] = $validated['options'];
            $data['answer_key'] = $validated['answer_key'];
        }

        // 3. Membuat aktivitas baru
        // Pastikan model HotsActivity memiliki 'options' di $casts dan semua field di $fillable
        HotsActivity::create($data);

        // 4. Kembali ke halaman detail materi dengan pesan sukses
        return redirect()->route('admin.materials.show', $material)
                         ->with('success', 'Aktivitas baru berhasil ditambahkan.');
    }


        /**
     * Menampilkan form untuk mengedit aktivitas.
     *
     * @param  \App\Models\HotsActivity  $activity
     * @return \Illuminate\View\View
     */
    public function edit(HotsActivity $activity)
    {
        // Model $activity sudah otomatis didapat dari route model binding
        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Memperbarui aktivitas di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HotsActivity  $activity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, HotsActivity $activity)
    {
        // 1. Validasi input dari form
        $validated = $request->validate([
            'question' => 'required|string|min:10',
            'type' => 'required|in:essay,multiple_choice',
            'options' => 'required_if:type,multiple_choice|array|size:4',
            'options.*' => 'required_if:type,multiple_choice|string|max:255',
            'answer_key' => 'required_if:type,multiple_choice|in:A,B,C,D',
        ]);

        // 2. Menyiapkan data untuk pembaruan agar konsisten
        $data = [
            'question' => $validated['question'],
            'type' => $validated['type'],
            'options' => null,
            'answer_key' => null,
        ];

        if ($validated['type'] === 'multiple_choice') {
            $data['options'] = $validated['options'];
            $data['answer_key'] = $validated['answer_key'];
        }

        // 3. Update aktivitas dengan data yang bersih
        $activity->update($data);

        // 4. Kembali ke halaman detail materi dengan pesan sukses
        return redirect()->route('admin.materials.show', $activity->reading_material_id)
                    ->with('success', 'Aktivitas berhasil diperbarui.');
    }

    /**
     * Menghapus aktivitas dari database.
     *
     * @param  \App\Models\HotsActivity  $activity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(HotsActivity $activity)
    {
        $materialId = $activity->reading_material_id;
        $activity->delete();

        return redirect()->route('admin.materials.show', $materialId)
                    ->with('success', 'Aktivitas berhasil dihapus.');
    }

}