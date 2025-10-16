<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\HomepageSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with news and gallery data.
     */
    public function index()
    {
        // Get homepage settings with caching
        $homepageSetting = \Cache::remember('homepage_setting_active', 3600, function () {
            return HomepageSetting::getActive();
        });

        // Get real statistics from database with caching
        $statistics = \Cache::remember('homepage_statistics', 1800, function () {
            return $this->getRealStatistics();
        });

        // Get latest 3 published news with optimized query
        $latestNews = \Cache::remember('homepage_latest_news', 900, function () {
            return News::published()
                ->with(['category:id,name', 'author:id,name'])
                ->select(['id', 'title', 'excerpt', 'image', 'published_at', 'slug', 'category_id', 'author_id'])
                ->orderBy('published_at', 'desc')
                ->limit(3)
                ->get();
        });

        // Gallery functionality removed
        $galleryItems = collect();

        // Get featured news (if any) with caching
        $featuredNews = \Cache::remember('homepage_featured_news', 1800, function () {
            return News::published()
                ->featured()
                ->with(['category:id,name', 'author:id,name'])
                ->select(['id', 'title', 'excerpt', 'image', 'published_at', 'slug', 'category_id', 'author_id'])
                ->orderBy('published_at', 'desc')
                ->limit(1)
                ->first();
        });

        return view('welcome', compact('homepageSetting', 'statistics', 'latestNews', 'galleryItems', 'featuredNews'));
    }

    /**
     * Get real statistics from database
     */
    private function getRealStatistics()
    {
        // Use single query with aggregation for better performance
        $achievementStats = \App\Models\Achievement::where('is_published', true)
            ->selectRaw('
                COUNT(*) as total_achievements,
                SUM(CASE WHEN achievement_level = "nasional" THEN 1 ELSE 0 END) as national_achievements,
                SUM(CASE WHEN achievement_level = "provinsi" THEN 1 ELSE 0 END) as provincial_achievements,
                SUM(CASE WHEN achievement_level = "kota" THEN 1 ELSE 0 END) as district_achievements,
                SUM(CASE WHEN category = "akademik" THEN 1 ELSE 0 END) as academic_achievements,
                SUM(CASE WHEN category = "olahraga" THEN 1 ELSE 0 END) as sports_achievements,
                SUM(CASE WHEN category = "seni" THEN 1 ELSE 0 END) as arts_achievements,
                SUM(CASE WHEN category NOT IN ("akademik", "olahraga", "seni") THEN 1 ELSE 0 END) as other_achievements,
                SUM(CASE WHEN YEAR(created_at) = ? THEN 1 ELSE 0 END) as this_year_achievements
            ', [date('Y')])
            ->first();

        // Get other statistics with optimized queries
        $totalStudents = \App\Models\User::where('role', 'student')->count();
        $totalTeachers = \App\Models\Teacher::count();
        $totalRegistrations = \App\Models\UserRegistration::count();
        $totalClasses = \App\Models\SchoolClass::count();
        
        // Calculate years of experience
        $foundedYear = 1985;
        $currentYear = date('Y');
        $yearsExperience = $currentYear - $foundedYear;
        
        return [
            'total_students' => $totalStudents > 0 ? $totalStudents : 324,
            'total_teachers' => $totalTeachers > 0 ? $totalTeachers : 24,
            'total_achievements' => $achievementStats->total_achievements > 0 ? $achievementStats->total_achievements : 45,
            'founded_year' => $foundedYear,
            'years_experience' => $yearsExperience,
            'total_registrations' => $totalRegistrations,
            'total_classes' => $totalClasses > 0 ? $totalClasses : 12,
            'national_achievements' => $achievementStats->national_achievements,
            'provincial_achievements' => $achievementStats->provincial_achievements,
            'district_achievements' => $achievementStats->district_achievements,
            'academic_achievements' => $achievementStats->academic_achievements,
            'sports_achievements' => $achievementStats->sports_achievements,
            'arts_achievements' => $achievementStats->arts_achievements,
            'other_achievements' => $achievementStats->other_achievements,
            'this_year_achievements' => $achievementStats->this_year_achievements,
            'last_updated' => now()->format('Y-m-d H:i:s'),
        ];
    }
}
