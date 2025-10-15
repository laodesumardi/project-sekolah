<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherActivity;
use Symfony\Component\HttpFoundation\Response;

class TrackTeacherActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Track activity only for authenticated teachers
        if (Auth::check() && Auth::user()->role === 'teacher' && Auth::user()->teacher) {
            $this->trackActivity($request);
        }

        return $response;
    }

    private function trackActivity(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return;
        }

        $routeName = $request->route()->getName();
        $method = $request->method();
        $path = $request->path();

        // Define activity types based on route
        $activityType = $this->getActivityType($routeName, $method);
        
        if (!$activityType) {
            return;
        }

        // Create activity record
        TeacherActivity::create([
            'teacher_id' => $teacher->id,
            'activity_type' => $activityType,
            'title' => $this->getActivityTitle($routeName, $method),
            'description' => $this->getActivityDescription($routeName, $method, $path),
            'date' => now()->toDateString(),
        ]);
    }

    private function getActivityType($routeName, $method)
    {
        if (str_contains($routeName, 'assignment')) {
            return TeacherActivity::TYPE_TEACHING;
        }
        
        if (str_contains($routeName, 'grade') || str_contains($routeName, 'attendance')) {
            return TeacherActivity::TYPE_TEACHING;
        }
        
        if (str_contains($routeName, 'learning-material')) {
            return TeacherActivity::TYPE_TEACHING;
        }
        
        if (str_contains($routeName, 'schedule')) {
            return TeacherActivity::TYPE_TEACHING;
        }
        
        if (str_contains($routeName, 'profile')) {
            return TeacherActivity::TYPE_OTHER;
        }
        
        return null;
    }

    private function getActivityTitle($routeName, $method)
    {
        $action = $this->getActionFromMethod($method);
        
        if (str_contains($routeName, 'assignment')) {
            return $action . ' Tugas';
        }
        
        if (str_contains($routeName, 'grade')) {
            return $action . ' Nilai';
        }
        
        if (str_contains($routeName, 'attendance')) {
            return $action . ' Absensi';
        }
        
        if (str_contains($routeName, 'learning-material')) {
            return $action . ' Materi Pembelajaran';
        }
        
        if (str_contains($routeName, 'schedule')) {
            return $action . ' Jadwal';
        }
        
        if (str_contains($routeName, 'profile')) {
            return $action . ' Profil';
        }
        
        return $action . ' Aktivitas';
    }

    private function getActivityDescription($routeName, $method, $path)
    {
        $action = $this->getActionFromMethod($method);
        $resource = $this->getResourceFromRoute($routeName);
        
        return "{$action} {$resource} pada " . now()->format('d/m/Y H:i');
    }

    private function getActionFromMethod($method)
    {
        return match($method) {
            'GET' => 'Melihat',
            'POST' => 'Membuat',
            'PUT', 'PATCH' => 'Memperbarui',
            'DELETE' => 'Menghapus',
            default => 'Mengakses',
        };
    }

    private function getResourceFromRoute($routeName)
    {
        if (str_contains($routeName, 'assignment')) {
            return 'Tugas';
        }
        
        if (str_contains($routeName, 'grade')) {
            return 'Nilai';
        }
        
        if (str_contains($routeName, 'attendance')) {
            return 'Absensi';
        }
        
        if (str_contains($routeName, 'learning-material')) {
            return 'Materi Pembelajaran';
        }
        
        if (str_contains($routeName, 'schedule')) {
            return 'Jadwal';
        }
        
        if (str_contains($routeName, 'profile')) {
            return 'Profil';
        }
        
        return 'Data';
    }
}
