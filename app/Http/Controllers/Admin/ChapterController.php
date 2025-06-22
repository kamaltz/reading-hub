<?php
// app/Http/Controllers/Admin/ChapterController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index()
    {
        // Mengurutkan berdasarkan nomor urut (sequence)
        $chapters = Chapter::orderBy('sequence')->get();
        return view('admin.chapters.index', compact('chapters'));
    }

    public function create()
    {
        return view('admin.chapters.create');
    }

    public function store(Request $request)
    {
        // Validasi untuk title dan sequence
        $request->validate([
            'title' => 'required|string|max:255',
            'sequence' => 'required|integer|min:1',
        ]);

        Chapter::create($request->all());

        return redirect()->route('admin.chapters.index')->with('success', 'Bab berhasil ditambahkan.');
    }

    public function edit(Chapter $chapter)
    {
        return view('admin.chapters.edit', compact('chapter'));
    }

    public function update(Request $request, Chapter $chapter)
    {
        // Validasi untuk title dan sequence
        $request->validate([
            'title' => 'required|string|max:255',
            'sequence' => 'required|integer|min:1',
        ]);

        $chapter->update($request->all());

        return redirect()->route('admin.chapters.index')->with('success', 'Bab berhasil diperbarui.');
    }

    public function destroy(Chapter $chapter)
    {
        $chapter->delete();

        return redirect()->route('admin.chapters.index')->with('success', 'Bab berhasil dihapus.');
    }
}