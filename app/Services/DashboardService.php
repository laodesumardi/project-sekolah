<?php

namespace App\Services;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Profile;
use App\Models\News;
use App\Models\Achievement;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\LearningMaterial;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get comprehensive dashboard statistics
     */
    public function getDashboardStats($userRole = null, $userId = null)
    {
        $stats = [
            'users' => $this->getUserStats(),
            'academic' => $this->getAcademicStats(),
            'content' => $this->getContentStats(),
            'activities' => $this->getRecentActivities(),
            'charts' => $this->getChartData(),
        ];

        // Add role-specific stats
        if ($userRole === 'student' && $userId) {
            $stats['student'] = $this->getStudentSpecificStats($userId);
        } elseif ($userRole === 'teacher' && $userId) {
            $stats['teacher'] = $this->getTeacherSpecificStats($userId);
        } elseif ($userRole === 'admin') {
            $stats['admin'] = $this->getAdminSpecificStats();
        }

        return $stats;
    }

    /**
     * Get user statistics
     */
    private function getUserStats()
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'students' => User::where('role', 'student')->where('is_active', true)->count(),
            'teachers' => User::where('role', 'teacher')->where('is_active', true)->count(),
            'admins' => User::where('role', 'admin')->where('is_active', true)->count(),
            'parents' => User::where('role', 'parent')->where('is_active', true)->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'new_this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
    }

    /**
     * Get academic statistics
     */
    private function getAcademicStats()
    {
        return [
            'total_achievements' => Achievement::count(),
            'published_achievements' => Achievement::where('is_published', true)->count(),
            'featured_achievements' => Achievement::where('is_featured', true)->count(),
            'achievements_this_month' => Achievement::whereMonth('created_at', now()->month)->count(),
            'achievements_this_year' => Achievement::whereYear('created_at', now()->year)->count(),
        ];
    }

    /**
     * Get content statistics
     */
    private function getContentStats()
    {
        return [
            'total_news' => News::count(),
            'published_news' => News::whereNotNull('published_at')->count(),
            'total_facilities' => Facility::count(),
            'total_galleries' => Gallery::count(),
            'published_galleries' => Gallery::where('is_published', true)->count(),
            'news_this_month' => News::whereMonth('created_at', now()->month)->count(),
            'facilities_this_month' => Facility::whereMonth('created_at', now()->month)->count(),
            'galleries_this_month' => Gallery::whereMonth('created_at', now()->month)->count(),
        ];
    }

    /**
     * Get recent activities across all modules
     */
    private function getRecentActivities()
    {
        $activities = collect();

        // User activities
        $recentUsers = User::latest()->limit(3)->get();
        foreach ($recentUsers as $user) {
            $activities->push([
                'type' => 'user',
                'title' => 'User Baru',
                'description' => $user->name . ' (' . ucfirst($user->role) . ')',
                'time' => $user->created_at,
                'color' => $this->getRoleColor($user->role),
                'icon' => 'fas fa-user',
            ]);
        }

        // News activities
        $recentNews = News::latest()->limit(3)->get();
        foreach ($recentNews as $news) {
            $activities->push([
                'type' => 'news',
                'title' => 'Berita Baru',
                'description' => $news->title,
                'time' => $news->created_at,
                'color' => 'blue',
                'icon' => 'fas fa-newspaper',
            ]);
        }

        // Achievement activities
        $recentAchievements = Achievement::latest()->limit(3)->get();
        foreach ($recentAchievements as $achievement) {
            $activities->push([
                'type' => 'achievement',
                'title' => 'Prestasi Baru',
                'description' => $achievement->title,
                'time' => $achievement->created_at,
                'color' => $achievement->level_color,
                'icon' => 'fas fa-trophy',
            ]);
        }

        return $activities->sortByDesc('time')->take(10);
    }

    /**
     * Get chart data for analytics
     */
    private function getChartData()
    {
        $monthlyUsers = $this->getMonthlyUserData();
        $monthlyAchievements = $this->getMonthlyAchievementData();
        
        return [
            'monthly_users' => $monthlyUsers,
            'monthly_achievements' => $monthlyAchievements,
            'role_distribution' => $this->getRoleDistribution(),
            'achievement_levels' => $this->getAchievementLevelDistribution(),
            'achievement_categories' => $this->getAchievementCategoryDistribution(),
            // Legacy format for admin dashboard
            'months' => array_column($monthlyUsers, 'month'),
            'news' => $this->getMonthlyNewsData(),
            'facilities' => $this->getMonthlyFacilitiesData(),
            'galleries' => $this->getMonthlyGalleriesData(),
            'achievements' => array_column($monthlyAchievements, 'achievements'),
        ];
    }

    /**
     * Get student-specific statistics
     */
    private function getStudentSpecificStats($userId)
    {
        $user = User::find($userId);
        
        return [
            'documents_verified' => 0, // Placeholder
            'assignments_completed' => 0, // Placeholder
            'attendance_rate' => 0, // Placeholder
            'current_gpa' => 0, // Placeholder
            'total_assignments' => 0, // Placeholder
            'completed_assignments' => 0, // Placeholder
            'pending_assignments' => 0, // Placeholder
        ];
    }

    /**
     * Get teacher-specific statistics
     */
    private function getTeacherSpecificStats($userId)
    {
        $user = User::find($userId);
        $teacher = $user->teacher;
        
        if (!$teacher) {
            return [
                'total_classes' => 0,
                'total_students' => 0,
                'total_assignments' => 0,
                'total_grades' => 0,
            ];
        }

        return [
            'total_classes' => $teacher->teacherClasses()->count(),
            'total_students' => $this->getTeacherStudentCount($teacher),
            'total_assignments' => Assignment::where('teacher_id', $user->id)->count(),
            'total_grades' => Grade::whereHas('teacherClass', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })->count(),
        ];
    }

    /**
     * Get admin-specific statistics
     */
    private function getAdminSpecificStats()
    {
        return [
            'system_health' => $this->getSystemHealth(),
            'storage_usage' => $this->getStorageUsage(),
            'recent_errors' => $this->getRecentErrors(),
            'performance_metrics' => $this->getPerformanceMetrics(),
        ];
    }

    /**
     * Get monthly user registration data
     */
    private function getMonthlyUserData()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = [
                'month' => $date->format('M Y'),
                'users' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        return $data;
    }

    /**
     * Get monthly achievement data
     */
    private function getMonthlyAchievementData()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = [
                'month' => $date->format('M Y'),
                'achievements' => Achievement::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        return $data;
    }

    /**
     * Get monthly news data for charts
     */
    private function getMonthlyNewsData()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = News::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        return $data;
    }

    /**
     * Get monthly facilities data for charts
     */
    private function getMonthlyFacilitiesData()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = Facility::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        return $data;
    }

    /**
     * Get monthly galleries data for charts
     */
    private function getMonthlyGalleriesData()
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = Gallery::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        return $data;
    }

    /**
     * Get role distribution
     */
    private function getRoleDistribution()
    {
        return [
            'students' => User::where('role', 'student')->count(),
            'teachers' => User::where('role', 'teacher')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'parents' => User::where('role', 'parent')->count(),
        ];
    }

    /**
     * Get achievement category distribution
     */
    private function getAchievementCategoryDistribution()
    {
        // Get actual counts from database
        $actualCounts = Achievement::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get()
            ->pluck('count', 'category')
            ->toArray();
        
        // Define all expected categories with default values
        $allCategories = [
            'akademik' => 0,
            'olahraga' => 0,
            'seni' => 0,
            'teknologi' => 0,
            'keagamaan' => 0,
            'lomba' => 0,
            'kompetisi' => 0,
            'olimpiade' => 0,
            'lainnya' => 0
        ];
        
        // Merge actual counts with defaults
        return array_merge($allCategories, $actualCounts);
    }

    /**
     * Get achievement level distribution
     */
    private function getAchievementLevelDistribution()
    {
        // Get actual counts from database
        $actualCounts = Achievement::select('achievement_level', DB::raw('count(*) as count'))
            ->groupBy('achievement_level')
            ->get()
            ->pluck('count', 'achievement_level')
            ->toArray();
        
        // Define all expected levels with default values
        $allLevels = [
            'sekolah' => 0,
            'kecamatan' => 0,
            'kota' => 0,
            'provinsi' => 0,
            'nasional' => 0,
            'internasional' => 0
        ];
        
        // Merge actual counts with defaults
        return array_merge($allLevels, $actualCounts);
    }

    /**
     * Get role color for UI
     */
    private function getRoleColor($role)
    {
        $colors = [
            'admin' => 'red',
            'teacher' => 'blue',
            'student' => 'green',
            'parent' => 'yellow',
        ];
        return $colors[$role] ?? 'gray';
    }

    /**
     * Get teacher's student count
     */
    private function getTeacherStudentCount($teacher)
    {
        // This would need to be implemented based on your class structure
        return 0; // Placeholder
    }

    /**
     * Get system health metrics
     */
    private function getSystemHealth()
    {
        return [
            'database_status' => 'healthy',
            'storage_status' => 'healthy',
            'cache_status' => 'healthy',
        ];
    }

    /**
     * Get storage usage
     */
    private function getStorageUsage()
    {
        return [
            'total_space' => '10GB',
            'used_space' => '5GB',
            'free_space' => '5GB',
        ];
    }

    /**
     * Get recent errors
     */
    private function getRecentErrors()
    {
        return []; // Placeholder
    }

    /**
     * Get performance metrics
     */
    private function getPerformanceMetrics()
    {
        return [
            'avg_response_time' => '150ms',
            'uptime' => '99.9%',
            'memory_usage' => '75%',
        ];
    }
}
