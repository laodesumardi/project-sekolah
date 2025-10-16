<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\HomepageSetting;
use Illuminate\Http\Request;

class AchievementStatisticsController extends Controller
{
    /**
     * Display the achievement statistics page.
     */
    public function index()
    {
        // Get real data from database
        $totalStudents = \App\Models\User::where('role', 'student')->count();
        $totalTeachers = \App\Models\Teacher::count();
        $totalAchievements = \App\Models\Achievement::where('is_published', true)->count();
        $totalRegistrations = \App\Models\UserRegistration::count();
        $totalClasses = \App\Models\SchoolClass::count();
        
        // Get statistics from homepage settings
        $homepageSetting = HomepageSetting::getActive();
        $statistics = [];
        
        if ($homepageSetting && $homepageSetting->about_page_achievements) {
            $statistics = json_decode($homepageSetting->about_page_achievements, true);
        }
        
        // Calculate real statistics
        $realStatistics = [
            'total_students' => $totalStudents > 0 ? $totalStudents : 324,
            'total_teachers' => $totalTeachers > 0 ? $totalTeachers : 24,
            'total_achievements' => $totalAchievements > 0 ? $totalAchievements : 45,
            'founded_year' => 1985,
            'years_experience' => 2025 - 1985, // 40 years
            'accreditation_grade' => 'A',
            'accreditation_year' => 2022,
            'accreditation_valid_until' => 2027,
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
        
        // Merge with saved statistics if available
        $statistics = array_merge($realStatistics, $statistics);
        
        // Get recent achievements
        $recentAchievements = Achievement::where('is_published', true)
            ->orderBy('date', 'desc')
            ->limit(6)
            ->get();
        
        return view('achievements.statistics', compact('statistics', 'recentAchievements'));
    }
}
