<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Arahkan pengguna berdasarkan perannya.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Arahkan admin ke panel Filament
            return redirect()->route('filament.admin.pages.dashboard');
        }

        // Siswa tetap melihat dasbor lama
        // (Gunakan logika dari controller Anda sebelumnya untuk mengambil data siswa)
        // ... (logika untuk mengambil data $materials, $chapters, dll.)
        return view('dashboard' /*, compact(...) */);
    }
}