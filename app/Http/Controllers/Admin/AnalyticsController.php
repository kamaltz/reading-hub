<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// TAMBAHKAN DUA BARIS INI
use App\Models\User;
use App\Models\HotsActivity;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Kode ini sekarang akan berjalan tanpa error
        $studentActivity = User::where('role', 'student')
            ->withCount('answers')
            ->orderBy('answers_count', 'desc')
            ->take(10)
            ->get();

        // Kode ini juga akan berjalan tanpa error
        $popularActivities = HotsActivity::withCount('answers')
            ->orderBy('answers_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.analytics.index', compact('studentActivity', 'popularActivities'));
    }
}