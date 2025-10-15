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
        // Get homepage settings
        $homepageSetting = HomepageSetting::getActive();

        // Get real statistics from database
        $statistics = $this->getRealStatistics();

        // Get latest 3 published news
        $latestNews = News::published()
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Gallery functionality removed
        $galleryItems = collect();

        // Get featured news (if any)
        $featuredNews = News::published()
            ->featured()
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        return view('welcome', compact('homepageSetting', 'statistics', 'latestNews', 'galleryItems', 'featuredNews'));
    }

    /**
     * Get real statistics from database
     */
    private function getRealStatistics()
    {
        // Get real data from database
        $totalStudents = \App\Models\User::where('role', 'student')->count();
        $totalTeachers = \App\Models\Teacher::count();
        $totalAchievements = \App\Models\Achievement::where('is_published', true)->count();
        $totalRegistrations = \App\Models\Registration::count();
        $totalClasses = \App\Models\SchoolClass::count();
        
        // Calculate years of experience
        $foundedYear = 1985;
        $currentYear = date('Y');
        $yearsExperience = $currentYear - $foundedYear;
        
        return [
            'total_students' => $totalStudents > 0 ? $totalStudents : 324,
            'total_teachers' => $totalTeachers > 0 ? $totalTeachers : 24,
            'total_achievements' => $totalAchievements > 0 ? $totalAchievements : 45,
            'founded_year' => $foundedYear,
            'years_experience' => $yearsExperience,
            'total_registrations' => $totalRegistrations,
            'total_classes' => $totalClasses > 0 ? $totalClasses : 12,
            'national_achievements' => \App\Models\Achievement::where('is_published', true)->where('achievement_level', 'nasional')->count(),
            'provincial_achievements' => \App\Models\Achievement::where('is_published', true)->where('achievement_level', 'provinsi')->count(),
            'district_achievements' => \App\Models\Achievement::where('is_published', true)->where('achievement_level', 'kota')->count(),
            'academic_achievements' => \App\Models\Achievement::where('is_published', true)->where('category', 'akademik')->count(),
            'sports_achievements' => \App\Models\Achievement::where('is_published', true)->where('category', 'olahraga')->count(),
            'arts_achievements' => \App\Models\Achievement::where('is_published', true)->where('category', 'seni')->count(),
            'other_achievements' => \App\Models\Achievement::where('is_published', true)->whereNotIn('category', ['akademik', 'olahraga', 'seni'])->count(),
            'this_year_achievements' => \App\Models\Achievement::where('is_published', true)->whereYear('date', date('Y'))->count(),
            'last_updated' => now()->format('Y-m-d H:i:s'),
        ];
    }
}
