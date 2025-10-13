<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Gallery;
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

        // Get latest 3 published news
        $latestNews = News::published()
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get latest 4 active gallery items
        $galleryItems = Gallery::active()
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Get featured news (if any)
        $featuredNews = News::published()
            ->featured()
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->limit(1)
            ->first();

        return view('welcome', compact('homepageSetting', 'latestNews', 'galleryItems', 'featuredNews'));
    }
}
