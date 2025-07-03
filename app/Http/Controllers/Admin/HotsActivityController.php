<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\HotsActivity;
use App\Models\ReadingMaterial; // Pastikan model ini di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotsActivityController extends Controller
{
    /**
     * Menampilkan semua aktivitas HOTS.
     */
    public function all()
    {
        $activities = HotsActivity::with('readingMaterial')->latest()->paginate(15);
        return view('admin.activities.all', compact('activities'));
    }

    /**
     * Menampilkan formulir untuk membuat aktivitas baru.
     */
    public function create()
    {
        // PERBAIKAN: Ambil semua materi dari database dan kirim ke view.
        $materials = ReadingMaterial::orderBy('title')->get();
        return view('admin.activities.create', compact('materials'));
    }

    /**
     * Menyimpan aktivitas baru ke database.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'reading_material_id' => 'required|exists:reading_materials,id',
                'type' => 'required|in:essay,multiple_choice,true_false,fill_in_blank,image_based',
                'question' => 'required|string',
                'options' => 'nullable|array',
                'correct_answer' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Process options for multiple choice
            if (($request->type === 'multiple_choice' || $request->type === 'image_based') && $request->options) {
                $processedOptions = [];
                foreach ($request->options as $index => $option) {
                    if (!empty($option)) {
                        $letter = chr(65 + $index); // A, B, C, D
                        $processedOptions[$letter] = $option;
                    }
                }
                $validated['options'] = $processedOptions;
            } else {
                $validated['options'] = null;
            }

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('activity_images', 'public');
            }
            
            $validated['position'] = HotsActivity::where('reading_material_id', $validated['reading_material_id'])->max('position') + 1;

            HotsActivity::create($validated);

            return redirect()->route('admin.materials.show', $validated['reading_material_id'])
                             ->with('success', 'Aktivitas berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Activity Store Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan formulir untuk mengedit aktivitas.
     */
    public function edit(HotsActivity $activity)
    {
        // Kirim juga daftar materi ke halaman edit, jika ingin bisa diubah
        $materials = ReadingMaterial::orderBy('title')->get();
        return view('admin.activities.edit', compact('activity', 'materials'));
    }

    /**
     * Memperbarui aktivitas di database.
     */
    public function update(Request $request, HotsActivity $activity)
    {
        $validated = $request->validate([
            'reading_material_id' => 'sometimes|required|exists:reading_materials,id',
            'type' => 'required|in:essay,multiple_choice,true_false,fill_in_blank,image_based',
            'question' => 'required|string',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }
            $validated['image'] = $request->file('image')->store('activity_images', 'public');
        }

        $activity->update($validated);

        $redirectMaterialId = $request->input('reading_material_id', $activity->reading_material_id);

        return redirect()->route('admin.materials.show', $redirectMaterialId)
                         ->with('success', 'Aktivitas berhasil diperbarui.');
    }

    /**
     * Menghapus aktivitas dari database.
     */
    public function destroy(HotsActivity $activity)
    {
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }
        
        $materialId = $activity->reading_material_id;
        $activity->delete();

        return redirect()->route('admin.materials.show', $materialId)
                         ->with('success', 'Aktivitas berhasil dihapus.');
    }

    /**
     * Menggandakan sebuah aktivitas.
     */
    public function duplicate(HotsActivity $activity)
    {
        $newActivity = $activity->replicate();
        $newActivity->position = HotsActivity::where('reading_material_id', $activity->reading_material_id)->max('position') + 1;
        $newActivity->save();

        return back()->with('success', 'Aktivitas berhasil digandakan.');
    }

    /**
     * Mengatur ulang urutan aktivitas.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer',
        ]);

        foreach ($request->order as $position => $id) {
            HotsActivity::where('id', $id)->update(['position' => $position + 1]);
        }

        return response()->json(['status' => 'success', 'message' => 'Urutan aktivitas berhasil diperbarui.']);
    }
}