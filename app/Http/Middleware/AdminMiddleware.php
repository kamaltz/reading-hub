<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Periksa apakah pengguna sudah login
        // 2. Periksa apakah role pengguna adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Jika ya, lanjutkan ke request berikutnya (controller)
            return $next($request);
        }

        // Jika tidak, hentikan proses dan tampilkan halaman error 403 (Forbidden)
        // Ini mencegah pengguna non-admin mengakses halaman admin.
        abort(403, 'AKSI TIDAK DIIZINKAN.');
    }
}