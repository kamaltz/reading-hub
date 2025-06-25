        foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
        return redirect(RouteServiceProvider::HOME);
        if (Auth::guard($guard)->check()) {
        /** @var \App\Models\User $user */
        $user = Auth::guard($guard)->user();

        if ($user->isAdmin()) {
        return redirect()->route('admin.materials.index');
        }

        return redirect(RouteServiceProvider::HOME);
        }
        }