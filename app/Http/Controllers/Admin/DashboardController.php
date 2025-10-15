<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        // Get comprehensive dashboard statistics
        $dashboardData = $this->dashboardService->getDashboardStats('admin');
        
        // Legacy stats for backward compatibility
        $stats = [
            'total_students' => $dashboardData['users']['students'],
            'total_teachers' => $dashboardData['users']['teachers'],
            'total_news' => $dashboardData['content']['total_news'],
            'total_facilities' => $dashboardData['content']['total_facilities'],
            'total_galleries' => $dashboardData['content']['total_galleries'],
            'total_achievements' => $dashboardData['academic']['total_achievements'],
        ];

        // Use dashboard service data
        $monthlyNews = $dashboardData['content']['news_this_month'];
        $monthlyFacilities = $dashboardData['content']['facilities_this_month'];
        $monthlyGalleries = $dashboardData['content']['galleries_this_month'];
        $monthlyAchievements = $dashboardData['academic']['achievements_this_month'];

        // Get recent activities from service
        $recentActivities = $dashboardData['activities'];

        // Get chart data from service
        $monthlyData = $dashboardData['charts']; // Use the full charts data with legacy format
        $achievementLevels = $dashboardData['charts']['achievement_levels'];
        $categoryData = $dashboardData['charts']['achievement_categories'];

        return view('admin.dashboard', compact(
            'stats',
            'dashboardData',
            'monthlyNews',
            'monthlyFacilities',
            'monthlyGalleries',
            'monthlyAchievements',
            'recentActivities',
            'monthlyData',
            'achievementLevels',
            'categoryData'
        ));
    }

    private function getMonthlyData()
    {
        $months = [];
        $newsData = [];
        $facilityData = [];
        $galleryData = [];
        $achievementData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $newsData[] = News::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $facilityData[] = Facility::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $galleryData[] = Gallery::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $achievementData[] = Achievement::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'months' => $months,
            'news' => $newsData,
            'facilities' => $facilityData,
            'galleries' => $galleryData,
            'achievements' => $achievementData
        ];
    }

    private function getAchievementLevels()
    {
        return [
            'sekolah' => Achievement::where('achievement_level', 'sekolah')->count(),
            'kecamatan' => Achievement::where('achievement_level', 'kecamatan')->count(),
            'kota' => Achievement::where('achievement_level', 'kota')->count(),
            'provinsi' => Achievement::where('achievement_level', 'provinsi')->count(),
            'nasional' => Achievement::where('achievement_level', 'nasional')->count(),
            'internasional' => Achievement::where('achievement_level', 'internasional')->count(),
        ];
    }

    private function getCategoryData()
    {
        return [
            'akademik' => Achievement::where('category', 'akademik')->count(),
            'olahraga' => Achievement::where('category', 'olahraga')->count(),
            'seni' => Achievement::where('category', 'seni')->count(),
            'teknologi' => Achievement::where('category', 'teknologi')->count(),
            'keagamaan' => Achievement::where('category', 'keagamaan')->count(),
            'lomba' => Achievement::where('category', 'lomba')->count(),
            'kompetisi' => Achievement::where('category', 'kompetisi')->count(),
            'olimpiade' => Achievement::where('category', 'olimpiade')->count(),
            'lainnya' => Achievement::where('category', 'lainnya')->count(),
        ];
    }
}

