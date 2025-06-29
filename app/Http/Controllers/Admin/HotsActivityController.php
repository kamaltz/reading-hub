<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotsActivity;
use App\Models\ReadingMaterial;
use Illuminate\Http\Request;

class HotsActivityController extends Controller
{
    /**
     * Menampilkan semua aktivitas.
     */
    public function all()
    {
        $activities = HotsActivity::with('readingMaterial')->latest()->get();
        return view('admin.activities.all', compact('activities'));
    }

    /**
     * Menampilkan form untuk membuat aktivitas baru untuk materi tertentu.
     */
    public function create(ReadingMaterial $material)
    {
        return view('admin.activities.create', compact('material'));
    }

    /**
     * Menyimpan aktivitas baru ke database.
     */
    public function store(Request $request)
    {
        $type = $request->input('type');
        $rules = [
            'reading_material_id' => 'required|exists:reading_materials,id',
            'type' => 'required|in:essay,multiple_choice,true_false,matching,fill_in_blank',
            'question' => 'required|string|min:5',
        ];

        if ($type === 'multiple_choice') {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*'] = 'required|string';
            $rules['correct_answer'] = 'required|string';
        } elseif ($type === 'true_false') {
            $rules['correct_answer'] = 'required|in:true,false';
        } elseif ($type === 'matching') {
            $rules['options'] = 'required|array|min:1';
            $rules['options.*.prompt'] = 'required|string';
            $rules['options.*.answer'] = 'required|string';
        } elseif ($type === 'fill_in_blank') {
            $rules['correct_answer'] = 'required|string';
        } elseif ($type === 'essay') {
            $rules['correct_answer'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        $options = null;
        if ($type === 'multiple_choice') {
            $options = array_filter($validated['options']);
        } elseif ($type === 'matching') {
            // Filter pasangan yang tidak lengkap dan re-index array
            $options = array_values(array_filter($validated['options'], function($pair) {
                return !empty($pair['prompt']) && !empty($pair['answer']);
            }));
        }

        HotsActivity::create([
            'reading_material_id' => $validated['reading_material_id'],
            'type' => $validated['type'],
            'question' => $validated['question'],
            // Ambil correct_answer jika ada di data tervalidasi
            'correct_answer' => $validated['correct_answer'] ?? null,
            'options' => $options,
        ]);

        // # PERBAIKAN: Mengirimkan ID materi saat redirect
        return redirect()->route('admin.materials.show', $validated['reading_material_id'])
                         ->with('success', 'Aktivitas baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit aktivitas.
     */
    public function edit(HotsActivity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Memperbarui aktivitas di database.
     */
    public function update(Request $request, HotsActivity $activity)
    {
        $type = $request->input('type');
        $rules = [
            'type' => 'required|in:essay,multiple_choice,true_false,matching,fill_in_blank',
            'question' => 'required|string|min:5',
        ];

        if ($type === 'multiple_choice') {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*'] = 'required|string';
            $rules['correct_answer'] = 'required|string';
        } elseif ($type === 'true_false') {
            $rules['correct_answer'] = 'required|in:true,false';
        } elseif ($type === 'matching') {
            $rules['options'] = 'required|array|min:1';
            $rules['options.*.prompt'] = 'required|string';
            $rules['options.*.answer'] = 'required|string';
        } elseif ($type === 'fill_in_blank') {
            $rules['correct_answer'] = 'required|string';
        } elseif ($type === 'essay') {
            $rules['correct_answer'] = 'nullable|string';
        }

        $validated = $request->validate($rules);

        $options = null;
        if ($type === 'multiple_choice') {
            $options = array_filter($validated['options']);
        } elseif ($type === 'matching') {
            // Filter pasangan yang tidak lengkap dan re-index array
            $options = array_values(array_filter($validated['options'], function($pair) {
                return !empty($pair['prompt']) && !empty($pair['answer']);
            }));
        }

        // Lakukan update pada aktivitas
        $activity->update([
            'type' => $validated['type'],
            'question' => $validated['question'],
            'correct_answer' => $validated['correct_answer'] ?? null,
            'options' => $options,
        ]);

        // Arahkan kembali ke halaman detail materi
        return redirect()->route('admin.materials.show', $activity->reading_material_id)
                         ->with('success', 'Aktivitas berhasil diperbarui.');
    }

    /**
     * Menghapus aktivitas dari database.
     */
    public function destroy(HotsActivity $activity)
    {
        // Simpan ID materi dari aktivitas yang akan dihapus.
        $readingMaterialId = $activity->reading_material_id;

        // Hapus aktivitas dari database.
        $activity->delete();

        // # SOLUSI FINAL:
        // Cek apakah aktivitas tersebut memiliki ID materi.
        if ($readingMaterialId) {
            // Jika ADA, kembali ke halaman detail materi seperti biasa.
            return redirect()->route('admin.materials.show', $readingMaterialId)
                            ->with('success', 'Aktivitas berhasil dihapus.');
        }

        // Jika TIDAK ADA ID materi (untuk menghindari error),
        // cukup kembali ke halaman sebelumnya.
        return back()->with('success', 'Aktivitas (tanpa materi terkait) berhasil dihapus.');
    }

    /**
     * Menduplikasi aktivitas.
     */
    public function duplicate(HotsActivity $activity)
    {
        $newActivity = $activity->replicate();
        $newActivity->question = $activity->question . ' (Salinan)';
        $newActivity->created_at = now();
        $newActivity->updated_at = now();
        $newActivity->save();

        return back()->with('success', 'Aktivitas berhasil diduplikasi.');
    }

    /**
     * Mengubah urutan aktivitas.
     */
    public function reorder(Request $request)
    {
        $request->validate(['ids' => 'required|array']);

        foreach ($request->ids as $index => $id) {
            HotsActivity::where('id', $id)->update(['position' => $index + 1]);
        }

        return response()->json(['status' => 'success']);
    }
}