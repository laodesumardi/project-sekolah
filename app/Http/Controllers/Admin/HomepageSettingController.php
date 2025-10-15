<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageSettingController extends Controller
{
    /**
     * Display the homepage settings.
     */
    public function index()
    {
        $homepageSetting = HomepageSetting::getActive();
        return view('admin.homepage-settings.index', compact('homepageSetting'));
    }

    /**
     * Show the form for editing the homepage settings.
     */
    public function edit()
    {
        $homepageSetting = HomepageSetting::getActive();
        return view('admin.homepage-settings.edit', compact('homepageSetting'));
    }

    /**
     * Update the homepage settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_button_1_text' => 'nullable|string|max:255',
            'hero_button_1_url' => 'nullable|string|max:255',
            'hero_button_2_text' => 'nullable|string|max:255',
            'hero_button_2_url' => 'nullable|string|max:255',
            'hero_background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_hero_background' => 'nullable|boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'school_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:255',
            'principal_name' => 'nullable|string|max:255',
            'principal_title' => 'nullable|string|max:255',
            'principal_message' => 'nullable|string',
            'principal_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'accreditation_grade' => 'nullable|string|max:255',
            'accreditation_description' => 'nullable|string',
            'accreditation_valid_until' => 'nullable|string|max:255',
            'accreditation_certificate' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about_page_title' => 'nullable|string|max:255',
            'about_page_description' => 'nullable|string',
            'about_page_mission' => 'nullable|string',
            'about_page_vision' => 'nullable|string',
            'about_page_history' => 'nullable|string',
            'about_page_principal_name' => 'nullable|string|max:255',
            'about_page_principal_title' => 'nullable|string|max:255',
            'about_page_principal_message' => 'nullable|string',
            'about_page_principal_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about_page_school_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about_page_organization_chart' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about_page_background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_about_background' => 'nullable|boolean',
            'curriculum_page_background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_curriculum_background' => 'nullable|boolean',
            'extracurricular_page_background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_extracurricular_background' => 'nullable|boolean',
            'gallery_page_background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_gallery_background' => 'nullable|boolean',
            'ppdb_page_background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_ppdb_background' => 'nullable|boolean',
            'news_page_background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_news_background' => 'nullable|boolean',
            'about_page_achievements' => 'nullable|string',
            'about_page_facilities_description' => 'nullable|string',
            'organization_structure_title' => 'nullable|string|max:255',
            'organization_structure_description' => 'nullable|string',
            'organization_structure_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'library_structure_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'library_operational_hours_weekdays' => 'nullable|string|max:255',
            'library_operational_hours_saturday' => 'nullable|string|max:255',
            'library_location' => 'nullable|string|max:255',
            'library_email' => 'nullable|email|max:255',
            'library_phone' => 'nullable|string|max:255',
        ]);

        $homepageSetting = HomepageSetting::getActive();

        if (!$homepageSetting) {
            $homepageSetting = new HomepageSetting();
        }

        // Handle hero background image removal
        if ($request->has('remove_hero_background') && $request->remove_hero_background) {
            if ($homepageSetting->hero_background_image) {
                Storage::delete($homepageSetting->hero_background_image);
                $homepageSetting->hero_background_image = null;
            }
        }

        // Handle about page background image removal
        if ($request->has('remove_about_background') && $request->remove_about_background) {
            if ($homepageSetting->about_page_background_image) {
                Storage::delete($homepageSetting->about_page_background_image);
                $homepageSetting->about_page_background_image = null;
            }
        }

        // Handle curriculum page background image removal
        if ($request->has('remove_curriculum_background') && $request->remove_curriculum_background) {
            if ($homepageSetting->curriculum_page_background_image) {
                Storage::delete($homepageSetting->curriculum_page_background_image);
                $homepageSetting->curriculum_page_background_image = null;
            }
        }

        // Handle extracurricular page background image removal
        if ($request->has('remove_extracurricular_background') && $request->remove_extracurricular_background) {
            if ($homepageSetting->extracurricular_page_background_image) {
                Storage::delete($homepageSetting->extracurricular_page_background_image);
                $homepageSetting->extracurricular_page_background_image = null;
            }
        }

        // Handle gallery page background image removal
        if ($request->has('remove_gallery_background') && $request->remove_gallery_background) {
            if ($homepageSetting->gallery_page_background_image) {
                Storage::delete($homepageSetting->gallery_page_background_image);
                $homepageSetting->gallery_page_background_image = null;
            }
        }

        // Handle PPDB page background image removal
        if ($request->has('remove_ppdb_background') && $request->remove_ppdb_background) {
            if ($homepageSetting->ppdb_page_background_image) {
                Storage::delete($homepageSetting->ppdb_page_background_image);
                $homepageSetting->ppdb_page_background_image = null;
            }
        }

        // Handle News page background image removal
        if ($request->has('remove_news_background') && $request->remove_news_background) {
            if ($homepageSetting->news_page_background_image) {
                Storage::delete($homepageSetting->news_page_background_image);
                $homepageSetting->news_page_background_image = null;
            }
        }

        // Handle file uploads
        if ($request->hasFile('hero_background_image')) {
            if ($homepageSetting->hero_background_image) {
                Storage::delete($homepageSetting->hero_background_image);
            }
            $homepageSetting->hero_background_image = $request->file('hero_background_image')->store('homepage', 'public');
        }

        if ($request->hasFile('logo')) {
            if ($homepageSetting->logo) {
                Storage::delete($homepageSetting->logo);
            }
            $homepageSetting->logo = $request->file('logo')->store('homepage', 'public');
        }

        if ($request->hasFile('school_image')) {
            if ($homepageSetting->school_image) {
                Storage::delete($homepageSetting->school_image);
            }
            $homepageSetting->school_image = $request->file('school_image')->store('homepage', 'public');
        }

        if ($request->hasFile('principal_photo')) {
            \Log::info('Principal photo file received', [
                'filename' => $request->file('principal_photo')->getClientOriginalName(),
                'size' => $request->file('principal_photo')->getSize(),
                'mime' => $request->file('principal_photo')->getMimeType()
            ]);
            
            if ($homepageSetting->principal_photo) {
                Storage::delete($homepageSetting->principal_photo);
            }
            $path = $request->file('principal_photo')->store('homepage', 'public');
            $homepageSetting->principal_photo = $path;
            \Log::info('Principal photo saved', ['path' => $path]);
        }

        if ($request->hasFile('accreditation_certificate')) {
            if ($homepageSetting->accreditation_certificate) {
                Storage::delete($homepageSetting->accreditation_certificate);
            }
            $homepageSetting->accreditation_certificate = $request->file('accreditation_certificate')->store('homepage', 'public');
        }

        if ($request->hasFile('about_page_principal_photo')) {
            if ($homepageSetting->about_page_principal_photo) {
                Storage::delete($homepageSetting->about_page_principal_photo);
            }
            $homepageSetting->about_page_principal_photo = $request->file('about_page_principal_photo')->store('homepage', 'public');
        }

        if ($request->hasFile('about_page_school_photo')) {
            if ($homepageSetting->about_page_school_photo) {
                Storage::delete($homepageSetting->about_page_school_photo);
            }
            $homepageSetting->about_page_school_photo = $request->file('about_page_school_photo')->store('homepage', 'public');
        }

        if ($request->hasFile('about_page_organization_chart')) {
            if ($homepageSetting->about_page_organization_chart) {
                Storage::delete($homepageSetting->about_page_organization_chart);
            }
            $homepageSetting->about_page_organization_chart = $request->file('about_page_organization_chart')->store('homepage', 'public');
        }

        if ($request->hasFile('about_page_background_image')) {
            if ($homepageSetting->about_page_background_image) {
                Storage::delete($homepageSetting->about_page_background_image);
            }
            $homepageSetting->about_page_background_image = $request->file('about_page_background_image')->store('homepage', 'public');
        }

        if ($request->hasFile('curriculum_page_background_image')) {
            if ($homepageSetting->curriculum_page_background_image) {
                Storage::delete($homepageSetting->curriculum_page_background_image);
            }
            $homepageSetting->curriculum_page_background_image = $request->file('curriculum_page_background_image')->store('homepage', 'public');
        }

        if ($request->hasFile('extracurricular_page_background_image')) {
            if ($homepageSetting->extracurricular_page_background_image) {
                Storage::delete($homepageSetting->extracurricular_page_background_image);
            }
            $homepageSetting->extracurricular_page_background_image = $request->file('extracurricular_page_background_image')->store('homepage', 'public');
        }

        if ($request->hasFile('gallery_page_background_image')) {
            if ($homepageSetting->gallery_page_background_image) {
                Storage::delete($homepageSetting->gallery_page_background_image);
            }
            $homepageSetting->gallery_page_background_image = $request->file('gallery_page_background_image')->store('homepage', 'public');
        }

        if ($request->hasFile('ppdb_page_background_image')) {
            if ($homepageSetting->ppdb_page_background_image) {
                Storage::delete($homepageSetting->ppdb_page_background_image);
            }
            $homepageSetting->ppdb_page_background_image = $request->file('ppdb_page_background_image')->store('homepage', 'public');
        }

        if ($request->hasFile('news_page_background_image')) {
            if ($homepageSetting->news_page_background_image) {
                Storage::delete($homepageSetting->news_page_background_image);
            }
            $homepageSetting->news_page_background_image = $request->file('news_page_background_image')->store('homepage', 'public');
        }

        if ($request->hasFile('organization_structure_image')) {
            if ($homepageSetting->organization_structure_image) {
                Storage::delete($homepageSetting->organization_structure_image);
            }
            $homepageSetting->organization_structure_image = $request->file('organization_structure_image')->store('homepage', 'public');
        }

        if ($request->hasFile('library_structure_image')) {
            if ($homepageSetting->library_structure_image) {
                Storage::delete($homepageSetting->library_structure_image);
            }
            $homepageSetting->library_structure_image = $request->file('library_structure_image')->store('homepage', 'public');
        }

        // Update other fields
        $homepageSetting->fill($request->except(['hero_background_image', 'logo', 'school_image', 'principal_photo', 'accreditation_certificate', 'about_page_principal_photo', 'about_page_school_photo', 'about_page_organization_chart', 'about_page_background_image', 'curriculum_page_background_image', 'extracurricular_page_background_image', 'gallery_page_background_image', 'news_page_background_image', 'ppdb_page_background_image', 'organization_structure_image', 'library_structure_image', 'remove_hero_background', 'remove_about_background', 'remove_curriculum_background', 'remove_extracurricular_background', 'remove_gallery_background', 'remove_news_background', 'remove_ppdb_background']));
        $homepageSetting->is_active = true;
        $homepageSetting->save();

        return redirect()->route('admin.homepage-settings.index')
            ->with('success', 'Pengaturan beranda berhasil diperbarui.');
    }

    /**
     * Update homepage settings via AJAX for live preview
     */
    public function updateAjax(Request $request)
    {
        $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|string|max:255',
            'contact_address' => 'nullable|string|max:255',
            'principal_name' => 'nullable|string|max:255',
            'principal_title' => 'nullable|string|max:255',
            'principal_message' => 'nullable|string',
            'accreditation_grade' => 'nullable|string|max:255',
            'accreditation_description' => 'nullable|string',
            'accreditation_valid_until' => 'nullable|string|max:255',
            'about_page_title' => 'nullable|string|max:255',
            'about_page_description' => 'nullable|string',
            'about_page_mission' => 'nullable|string',
            'about_page_vision' => 'nullable|string',
            'about_page_history' => 'nullable|string',
            'about_page_principal_name' => 'nullable|string|max:255',
            'about_page_principal_title' => 'nullable|string|max:255',
            'about_page_principal_message' => 'nullable|string',
            'about_page_achievements' => 'nullable|string',
            'about_page_facilities_description' => 'nullable|string',
            'organization_structure_title' => 'nullable|string|max:255',
            'organization_structure_description' => 'nullable|string',
            'organization_structure_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'library_structure_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'library_operational_hours_weekdays' => 'nullable|string|max:255',
            'library_operational_hours_saturday' => 'nullable|string|max:255',
            'library_location' => 'nullable|string|max:255',
            'library_email' => 'nullable|email|max:255',
            'library_phone' => 'nullable|string|max:255',
        ]);

        $homepageSetting = HomepageSetting::getActive();

        if (!$homepageSetting) {
            $homepageSetting = new HomepageSetting();
        }

        // Update only text fields for AJAX
        $homepageSetting->fill($request->only([
            'hero_title', 'hero_subtitle', 'hero_description',
            'contact_phone', 'contact_email', 'contact_address',
            'principal_name', 'principal_title', 'principal_message',
            'accreditation_grade', 'accreditation_description', 'accreditation_valid_until',
            'about_page_title', 'about_page_description', 'about_page_mission', 'about_page_vision',
            'about_page_history',             'about_page_principal_name', 'about_page_principal_title',
            'about_page_principal_message', 'about_page_achievements', 'about_page_facilities_description',
            'library_operational_hours_weekdays', 'library_operational_hours_saturday',
            'library_location', 'library_email', 'library_phone'
        ]));
        
        $homepageSetting->is_active = true;
        $homepageSetting->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil diperbarui',
            'data' => $homepageSetting
        ]);
    }
}
