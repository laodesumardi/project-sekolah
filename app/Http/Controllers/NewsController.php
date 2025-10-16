<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Tag;
use App\Models\HomepageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class NewsController extends Controller
{
    /**
     * Display a listing of news.
     */
    public function index(Request $request)
    {
        $query = News::published()->with(['category', 'author', 'tags']);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by tag
        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Featured filter
        if ($request->has('featured') && $request->featured) {
            $query->featured();
        }

        $news = $query->orderBy('published_at', 'desc')->paginate(15);
        
        // Get sidebar data with caching
        $categories = \Cache::remember('news_categories', 3600, function () {
            return NewsCategory::withCount('news')->get();
        });
        
        $popularNews = \Cache::remember('news_popular', 1800, function () {
            return News::popular(5)
                ->select(['id', 'title', 'excerpt', 'image', 'published_at', 'slug'])
                ->get();
        });
        
        $recentNews = \Cache::remember('news_recent', 900, function () {
            return News::recent(5)
                ->select(['id', 'title', 'excerpt', 'image', 'published_at', 'slug'])
                ->get();
        });
        
        $popularTags = \Cache::remember('news_popular_tags', 3600, function () {
            return Tag::popular(10)->get();
        });
        
        $homepageSetting = \Cache::remember('homepage_setting_active', 3600, function () {
            return HomepageSetting::getActive();
        });

        return view('frontend.news.index', compact(
            'news', 
            'categories', 
            'popularNews', 
            'recentNews', 
            'popularTags',
            'homepageSetting'
        ));
    }

    /**
     * Display the specified news.
     */
    public function show($slug)
    {
        $news = News::where('slug', $slug)->first();
        
        if (!$news) {
            abort(404);
        }
        
        // Check if news is published
        if (!$news->published_at || $news->published_at > now()) {
            abort(404);
        }

        // Increment view count (once per 24 hours per user)
        $viewKey = 'news_viewed_' . $news->id;
        if (!Cookie::has($viewKey)) {
            $news->increment('views');
            Cookie::queue($viewKey, true, 60 * 24); // 24 hours
        }

        // Get related news
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category_id', $news->category_id)
            ->limit(4)
            ->get();

        // Get popular tags
        $popularTags = Tag::popular(10)->get();

        // Get recent news for sidebar
        $recentNews = News::published()
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        $homepageSetting = HomepageSetting::getActive();

        return view('frontend.news.show', compact('news', 'relatedNews', 'popularTags', 'recentNews', 'homepageSetting'));
    }

    /**
     * Get news by category.
     */
    public function category(NewsCategory $category)
    {
        $news = News::published()
            ->where('category_id', $category->id)
            ->with(['author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        $categories = NewsCategory::withCount('news')->get();
        $popularNews = News::popular(5)->get();
        $recentNews = News::recent(5)->get();

        $homepageSetting = HomepageSetting::getActive();

        return view('frontend.news.category', compact(
            'news', 
            'category', 
            'categories', 
            'popularNews', 
            'recentNews',
            'homepageSetting'
        ));
    }

    /**
     * Get news by tag.
     */
    public function tag(Tag $tag)
    {
        $news = News::published()
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('tag_id', $tag->id);
            })
            ->with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(15);

        $categories = NewsCategory::withCount('news')->get();
        $popularNews = News::popular(5)->get();
        $recentNews = News::recent(5)->get();

        $homepageSetting = HomepageSetting::getActive();

        return view('frontend.news.tag', compact(
            'news', 
            'tag', 
            'categories', 
            'popularNews', 
            'recentNews',
            'homepageSetting'
        ));
    }

    /**
     * RSS Feed for news.
     */
    public function feed()
    {
        $news = News::published()
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();

        return response()->view('frontend.news.feed', compact('news'))
            ->header('Content-Type', 'application/rss+xml');
    }
}