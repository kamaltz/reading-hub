<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity; // Menggunakan model Activity yang baru
use App\Models\User;
use App\Models\ReadingMaterial;
use Illuminate\Http\Request;
use Inertia\Inertia; // <-- Impor Inertia

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard khusus untuk admin.
     * Kita ubah menjadi __invoke agar lebih sederhana, karena controller ini hanya punya satu aksi.
     */
    public function __invoke(Request $request)
    {
        // Mengambil semua data statistik yang relevan untuk admin
        $stats = [
            'totalMaterials' => ReadingMaterial::count(),
            'totalActivities' => Activity::count(),
            'totalStudents' => User::where('role', 'student')->count(),
            // Anda bisa menambahkan statistik lain di sini jika perlu
        ];

        // Render komponen React khusus untuk admin: 'Admin/Dashboard.jsx'
        // dan kirim data 'stats' sebagai props.
        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats
        ]);
    }
}