<?php

namespace App\Http\Controllers;

use App\Models\HomepageSetting;
use Illuminate\Http\Request;

class AccreditationController extends Controller
{
    /**
     * Display the accreditation page.
     */
    public function index()
    {
        $homepageSetting = HomepageSetting::getActive();
        return view('frontend.accreditation.index', compact('homepageSetting'));
    }
}