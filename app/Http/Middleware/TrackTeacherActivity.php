<?php

namespace App\Http\Middleware;

use App\Models\TeacherActivity;
use Closure;
use Illuminate\Http\Request;
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

        // Track activity for teachers
        if (auth()->check() && auth()->user()->role === 'teacher' && auth()->user()->teacher) {
            $this->trackActivity($request);
        }

        return $response;
    }

    /**
     * Track teacher activity.
     */
    private function trackActivity(Request $request)
    {
        $teacher = auth()->user()->teacher;
        $route = $request->route();
        
        // Determine activity type based on route
        $activityType = $this->getActivityType($request);
        
        // Skip tracking for certain routes
        if (in_array($activityType, ['dashboard', 'profile.show', 'sessions'])) {
            return;
        }

        // Create activity record
        TeacherActivity::create([
            'teacher_id' => $teacher->id,
            'activity_type' => $activityType,
            'description' => $this->getActivityDescription($request, $activityType),
            'metadata' => $this->getActivityMetadata($request),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * Get activity type from request.
     */
    private function getActivityType(Request $request)
    {
        $route = $request->route();
        $routeName = $route ? $route->getName() : '';
        
        // Extract activity type from route name
        if (str_contains($routeName, 'login')) {
            return 'login';
        } elseif (str_contains($routeName, 'logout')) {
            return 'logout';
        } elseif (str_contains($routeName, 'upload') || str_contains($routeName, 'photo')) {
            return 'upload';
        } elseif (str_contains($routeName, 'grade') || str_contains($routeName, 'nilai')) {
            return 'grade';
        } elseif (str_contains($routeName, 'attendance') || str_contains($routeName, 'absensi')) {
            return 'attendance';
        } elseif (str_contains($routeName, 'message') || str_contains($routeName, 'pesan')) {
            return 'message';
        } elseif (str_contains($routeName, 'profile.update')) {
            return 'profile_update';
        } elseif (str_contains($routeName, 'password')) {
            return 'password_change';
        } elseif (str_contains($routeName, 'document')) {
            return 'document_upload';
        } elseif (str_contains($routeName, 'certification')) {
            return 'certification_add';
        } else {
            return 'other';
        }
    }

    /**
     * Get activity description.
     */
    private function getActivityDescription(Request $request, $activityType)
    {
        $route = $request->route();
        $routeName = $route ? $route->getName() : '';
        
        return match($activityType) {
            'login' => 'Guru login ke sistem',
            'logout' => 'Guru logout dari sistem',
            'upload' => 'Guru mengupload file',
            'grade' => 'Guru menginput nilai',
            'attendance' => 'Guru menginput absensi',
            'message' => 'Guru mengirim pesan',
            'profile_update' => 'Guru mengupdate profile',
            'password_change' => 'Guru mengubah password',
            'document_upload' => 'Guru mengupload dokumen',
            'certification_add' => 'Guru menambah sertifikasi',
            default => 'Guru mengakses ' . $routeName
        };
    }

    /**
     * Get activity metadata.
     */
    private function getActivityMetadata(Request $request)
    {
        $metadata = [
            'route' => $request->route() ? $request->route()->getName() : null,
            'method' => $request->method(),
            'url' => $request->url(),
        ];

        // Add specific metadata based on request
        if ($request->has('subject_id')) {
            $metadata['subject_id'] = $request->subject_id;
        }
        if ($request->has('class_id')) {
            $metadata['class_id'] = $request->class_id;
        }
        if ($request->hasFile('photo')) {
            $metadata['file_type'] = 'photo';
        }
        if ($request->hasFile('document')) {
            $metadata['file_type'] = 'document';
        }

        return $metadata;
    }
}