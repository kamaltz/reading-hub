<?php

namespace App\Http\Controllers;

use App\Models\HotsActivity;
use App\Models\ReadingMaterial;
use App\Models\StudentHotsActivityAnswer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $user = Auth::user();
        $viewData = [];

        if ($user->isAdmin()) {
            // Data for Admin Dashboard
            $viewData = [
                'totalMaterials' => ReadingMaterial::count(),
                'totalActivities' => HotsActivity::count(),
                'totalStudents' => User::where('role', 'student')->count(),
                'totalAnswers' => StudentHotsActivityAnswer::count(),
            ];
        } else {
            // Data for Student Dashboard
            $userId = $user->id;

            // Total activities attempted by the student
            $totalAttemptedActivities = StudentHotsActivityAnswer::where('user_id', $userId)->count();

            // Total activities answered correctly by the student
            $completedActivities = StudentHotsActivityAnswer::where('user_id', $userId)
                                                            ->where('is_correct', true)
                                                            ->count();

            // Total number of all available activities in the system
            $totalAvailableActivities = HotsActivity::count();

            $viewData = [
                'totalAttemptedActivities' => $totalAttemptedActivities,
                'completedActivities' => $completedActivities,
                'totalAvailableActivities' => $totalAvailableActivities,
            ];
        }

        return view('dashboard', $viewData);
    }
}