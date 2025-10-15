<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::published()->with(['images', 'participants', 'teachers']);

        // Filter by level
        if ($request->has('level') && $request->level !== 'all') {
            $query->byLevel($request->level);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Filter by year
        if ($request->has('year') && $request->year !== 'all') {
            $query->byYear($request->year);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Sort
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('date', 'asc');
                break;
            case 'level':
                $query->orderByRaw("FIELD(achievement_level, 'sekolah', 'kecamatan', 'kota', 'provinsi', 'nasional', 'internasional') DESC");
                break;
            case 'views':
                $query->orderBy('view_count', 'desc');
                break;
            case 'name':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->recent();
        }

        $achievements = $query->paginate(12);

        // Get statistics
        $stats = [
            'total' => Achievement::published()->count(),
            'national' => Achievement::published()->byLevel('nasional')->count(),
            'international' => Achievement::published()->byLevel('internasional')->count(),
            'this_year' => Achievement::published()->byYear(date('Y'))->count()
        ];

        // Get featured achievements
        $featured = Achievement::published()->featured()->recent()->limit(3)->get();

        // Get filter options
        $levels = Achievement::published()->select('achievement_level', DB::raw('count(*) as count'))
            ->groupBy('achievement_level')
            ->pluck('count', 'achievement_level');

        $categories = Achievement::published()->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->pluck('count', 'category');

        $years = Achievement::published()->select('year', DB::raw('count(*) as count'))
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('count', 'year');

        return view('achievements.index', compact(
            'achievements',
            'stats',
            'featured',
            'levels',
            'categories',
            'years'
        ));
    }

    public function show($slug)
    {
        $achievement = Achievement::published()
            ->where('slug', $slug)
            ->with(['images', 'participants.student', 'teachers.teacher'])
            ->firstOrFail();

        // Increment view count
        $achievement->incrementViewCount();

        // Get related achievements (same category or level)
        $related = Achievement::published()
            ->where('id', '!=', $achievement->id)
            ->where(function ($query) use ($achievement) {
                $query->where('category', $achievement->category)
                      ->orWhere('achievement_level', $achievement->achievement_level);
            })
            ->recent()
            ->limit(6)
            ->get();

        return view('achievements.show', compact('achievement', 'related'));
    }

    public function filter(Request $request)
    {
        $query = Achievement::published();

        if ($request->has('level') && $request->level !== 'all') {
            $query->byLevel($request->level);
        }

        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        if ($request->has('year') && $request->year !== 'all') {
            $query->byYear($request->year);
        }

        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        $achievements = $query->recent()->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('achievements.partials.achievement-grid', compact('achievements'))->render(),
                'pagination' => $achievements->links()->render()
            ]);
        }

        return view('achievements.index', compact('achievements'));
    }
}