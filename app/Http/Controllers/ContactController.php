<?php

namespace App\Http\Controllers;

use App\Models\HomepageSetting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        $homepageSetting = HomepageSetting::getActive();
        return view('frontend.contact.index', compact('homepageSetting'));
    }
}