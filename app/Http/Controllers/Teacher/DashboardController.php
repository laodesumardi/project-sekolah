<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Assignment;
use App\Models\Schedule;
use App\Models\LearningMaterial;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.profile.create')
                ->with('error', 'Profil guru belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }
        
        // Get today's schedule
        $todaySchedule = $teacher->schedules()
            ->where('day_of_week', Carbon::now()->dayOfWeek)
            ->with(['class', 'subject'])
            ->get();

        // Get pending assignments
        $pendingAssignments = $teacher->assignments()
            ->where('is_published', true)
            ->where('due_date', '>', now())
            ->with(['class', 'subject'])
            ->orderBy('due_date')
            ->limit(5)
            ->get();
        
        // Get recent activities
        $recentActivities = $teacher->activities()
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        // Get statistics
        $stats = [
            'total_assignments' => $teacher->assignments()->count(),
            'published_assignments' => $teacher->assignments()->where('is_published', true)->count(),
            'total_materials' => $teacher->learningMaterials()->count(),
            'published_materials' => $teacher->learningMaterials()->where('is_published', true)->count(),
            'total_classes' => $teacher->classes()->count(),
            'total_subjects' => $teacher->subjects()->count(),
        ];

        // Get upcoming assignments
        $upcomingAssignments = $teacher->assignments()
            ->where('is_published', true)
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(7))
            ->with(['class', 'subject'])
            ->orderBy('due_date')
            ->get();

        // Get overdue assignments
        $overdueAssignments = $teacher->assignments()
            ->where('is_published', true)
            ->where('due_date', '<', now())
            ->with(['class', 'subject'])
            ->orderBy('due_date')
            ->get();

        return view('teacher.dashboard', compact(
            'teacher',
            'todaySchedule',
            'pendingAssignments',
            'recentActivities',
            'stats',
            'upcomingAssignments',
            'overdueAssignments'
        ));
    }
    
    public function getStats()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Teacher profile not found'], 404);
        }

        $stats = [
            'total_assignments' => $teacher->assignments()->count(),
            'published_assignments' => $teacher->assignments()->where('is_published', true)->count(),
            'total_materials' => $teacher->learningMaterials()->count(),
            'published_materials' => $teacher->learningMaterials()->where('is_published', true)->count(),
            'total_classes' => $teacher->classes()->count(),
            'total_subjects' => $teacher->subjects()->count(),
        ];
        
        return response()->json($stats);
    }
    
    public function getScheduleToday()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Teacher profile not found'], 404);
        }

        $todaySchedule = $teacher->schedules()
            ->where('day_of_week', Carbon::now()->dayOfWeek)
            ->with(['class', 'subject'])
            ->get();

        return response()->json($todaySchedule);
    }

    public function getPendingTasks()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Teacher profile not found'], 404);
        }

        $pendingTasks = [];

        // Get assignments that need grading
        $assignmentsToGrade = $teacher->assignments()
            ->whereHas('submissions', function ($query) {
                $query->whereNull('score');
            })
            ->with(['class', 'subject'])
            ->get();

        foreach ($assignmentsToGrade as $assignment) {
            $pendingTasks[] = [
                'type' => 'assignment_grading',
                'title' => 'Nilai Tugas: ' . $assignment->title,
                'description' => 'Kelas: ' . $assignment->class->name . ' - ' . $assignment->subject->name,
                'due_date' => $assignment->due_date,
                'priority' => $assignment->due_date < now() ? 'high' : 'medium',
            ];
        }

        // Get upcoming assignments
        $upcomingAssignments = $teacher->assignments()
            ->where('is_published', true)
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(3))
            ->with(['class', 'subject'])
            ->get();

        foreach ($upcomingAssignments as $assignment) {
            $pendingTasks[] = [
                'type' => 'assignment_upcoming',
                'title' => 'Tugas Mendatang: ' . $assignment->title,
                'description' => 'Kelas: ' . $assignment->class->name . ' - ' . $assignment->subject->name,
                'due_date' => $assignment->due_date,
                'priority' => 'low',
            ];
        }

        return response()->json($pendingTasks);
    }

    public function getActivities()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Teacher profile not found'], 404);
        }

        $activities = $teacher->activities()
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        return response()->json($activities);
    }
}
