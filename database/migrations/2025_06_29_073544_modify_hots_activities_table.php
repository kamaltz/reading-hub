<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotsActivity;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Ambil semua siswa
        $students = User::where('role', 'student')->get();
        // Hitung total semua aktivitas yang ada di sistem
        $totalActivities = HotsActivity::count();

        // Loop setiap siswa untuk menghitung progress mereka
        foreach ($students as $student) {
            if ($totalActivities > 0) {
                // Hitung berapa banyak aktivitas yang sudah dijawab benar oleh siswa
                $completedCount = $student->answers()->where('is_correct', true)->count();
                // Hitung persentase progress
                $student->progress = round(($completedCount / $totalActivities) * 100);
            } else {
                // Jika tidak ada aktivitas sama sekali, progress 0
                $student->progress = 0;
            }
        }

        return view('admin.students.index', compact('students'));
    }
}