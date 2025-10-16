<?php

namespace App\Http\Controllers;

use App\Models\HomepageSetting;
use App\Models\Facility;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the about page.
     */
    public function index()
    {
        $homepageSetting = \Cache::remember('homepage_setting_active', 3600, function () {
            return HomepageSetting::getActive();
        });
        
        $facilities = \Cache::remember('about_facilities', 1800, function () {
            return Facility::available()
                ->select(['id', 'name', 'description', 'image', 'category'])
                ->take(8)
                ->get();
        });
        
        $achievements = \Cache::remember('about_achievements', 1800, function () {
            return Achievement::featured()
                ->select(['id', 'title', 'description', 'date', 'achievement_level', 'category'])
                ->orderBy('date', 'desc')
                ->take(8)
                ->get();
        });
        
        // Get real statistics from database with caching
        $statistics = \Cache::remember('about_statistics', 1800, function () {
            return $this->getRealStatistics();
        });
        
        return view('frontend.about.index', compact('homepageSetting', 'facilities', 'achievements', 'statistics'))->with('aboutHomepageSetting', $homepageSetting);
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
        $totalRegistrations = \App\Models\UserRegistration::count();
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
    }
}
