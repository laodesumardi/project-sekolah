<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get student-specific dashboard data
        $dashboardData = $this->dashboardService->getDashboardStats('student', $user->id);
        
        // Get student profile data
        $profile = $user->profile;
        $academicData = $this->getAcademicData($profile);
        
        // Get student statistics
        $stats = [
            'documents_verified' => $dashboardData['student']['documents_verified'],
            'assignments_completed' => $dashboardData['student']['assignments_completed'],
            'attendance_rate' => $dashboardData['student']['attendance_rate'],
            'current_gpa' => $dashboardData['student']['current_gpa'],
            'total_assignments' => $dashboardData['student']['total_assignments'],
            'completed_assignments' => $dashboardData['student']['completed_assignments'],
            'pending_assignments' => $dashboardData['student']['pending_assignments'],
        ];

        return view('student.dashboard', compact(
            'dashboardData',
            'profile',
            'academicData',
            'stats'
        ));
    }

    /**
     * Get academic data for student
     */
    private function getAcademicData($profile)
    {
        if (!$profile) {
            return [
                'current_class' => 'Tidak ada data',
                'entry_year' => 'Tidak ada data',
                'active_semester' => 'Tidak ada data',
                'homeroom_teacher' => 'Tidak ada data',
                'student_status' => 'Tidak ada data',
            ];
        }

        return [
            'current_class' => $profile->class ? $profile->class->name : 'Tidak ada data',
            'entry_year' => $profile->entry_year ?? 'Tidak ada data',
            'active_semester' => $profile->active_semester ?? 'Tidak ada data',
            'homeroom_teacher' => $profile->class && $profile->class->homeroomTeacher 
                ? $profile->class->homeroomTeacher->name 
                : 'Tidak ada data',
            'student_status' => $profile->status ?? 'Aktif',
        ];
    }
}