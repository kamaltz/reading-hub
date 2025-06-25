        foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
        return redirect(RouteServiceProvider::HOME);
        // Logika Tambahan: Arahkan berdasarkan role
        $user = Auth::user();
        if ($user->isAdmin()) {
        return redirect()->route('admin.materials.index'); // Atau route dashboard admin lainnya
        }

        return redirect()->route('dashboard'); // Arahkan ke dashboard siswa
        }
        }