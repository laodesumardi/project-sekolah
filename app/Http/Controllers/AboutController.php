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
        $homepageSetting = HomepageSetting::getActive();
        $facilities = Facility::available()->take(8)->get();
        $achievements = Achievement::featured()->orderBy('date', 'desc')->take(8)->get();
        
        return view('frontend.about.index', compact('homepageSetting', 'facilities', 'achievements'));
    }
}
