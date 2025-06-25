<?php

namespace App\Http\Controllers;

use App\Models\ReadingMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReadingMaterialViewController extends Controller
{
    /**
     * Menampilkan detail materi bacaan beserta aktivitasnya.
     */
    public function show(ReadingMaterial $material): View
    {
        // Eager load aktivitas untuk mencegah N+1 query
        $material->load('hotsActivities');
        $activities = $material->hotsActivities;

        // Ambil semua jawaban siswa untuk aktivitas di materi ini,
        // lalu jadikan activity_id sebagai key agar mudah dicari di view.
        $userAnswers = Auth::user()
            ->hotsActivityAnswers()
            ->whereIn('hots_activity_id', $activities->pluck('id'))
            ->get()
            ->keyBy('hots_activity_id');

        return view('materials.show', compact('material', 'activities', 'userAnswers'));
    }
}