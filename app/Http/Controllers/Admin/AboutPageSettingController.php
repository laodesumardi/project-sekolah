<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutPageSettingController extends Controller
{
    /**
     * Display the about page settings.
     */
    public function index()
    {
        $aboutPageSetting = AboutPageSetting::getActive();
        return view('admin.about-page-settings.index', compact('aboutPageSetting'));
    }

    /**
     * Show the form for editing the about page settings.
     */
    public function edit()
    {
        $aboutPageSetting = AboutPageSetting::getActive();
        return view('admin.about-page-settings.edit', compact('aboutPageSetting'));
    }

    /**
     * Update the about page settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'page_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'history' => 'nullable|string',
            'principal_name' => 'nullable|string|max:255',
            'principal_title' => 'nullable|string|max:255',
            'principal_message' => 'nullable|string',
            'principal_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'school_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'organization_chart' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'achievements' => 'nullable|string',
            'facilities_description' => 'nullable|string',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'remove_principal_photo' => 'nullable|boolean',
        ]);

        $aboutPageSetting = AboutPageSetting::getActive();

        if (!$aboutPageSetting) {
            $aboutPageSetting = new AboutPageSetting();
        }

        // Handle principal photo removal
        if ($request->has('remove_principal_photo') && $request->remove_principal_photo) {
            if ($aboutPageSetting->principal_photo) {
                Storage::delete($aboutPageSetting->principal_photo);
                $aboutPageSetting->principal_photo = null;
            }
        }

        // Handle file uploads
        if ($request->hasFile('principal_photo')) {
            if ($aboutPageSetting->principal_photo) {
                Storage::delete($aboutPageSetting->principal_photo);
            }
            $aboutPageSetting->principal_photo = $request->file('principal_photo')->store('about-page', 'public');
        }

        if ($request->hasFile('school_photo')) {
            if ($aboutPageSetting->school_photo) {
                Storage::delete($aboutPageSetting->school_photo);
            }
            $aboutPageSetting->school_photo = $request->file('school_photo')->store('about-page', 'public');
        }

        if ($request->hasFile('organization_chart')) {
            if ($aboutPageSetting->organization_chart) {
                Storage::delete($aboutPageSetting->organization_chart);
            }
            $aboutPageSetting->organization_chart = $request->file('organization_chart')->store('about-page', 'public');
        }

        // Update other fields
        $aboutPageSetting->fill($request->except(['principal_photo', 'school_photo', 'organization_chart']));
        $aboutPageSetting->is_active = true;
        $aboutPageSetting->save();

        return redirect()->route('admin.about-page-settings.index')
            ->with('success', 'Pengaturan halaman Tentang Kami berhasil diperbarui.');
    }
}
