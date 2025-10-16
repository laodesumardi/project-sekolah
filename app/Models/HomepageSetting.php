<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'hero_button_1_text',
        'hero_button_1_url',
        'hero_button_2_text',
        'hero_button_2_url',
        'hero_background_image',
        'logo',
        'school_image',
        'vision_title',
        'vision_description',
        'mission_description',
        'about_description',
        'contact_phone',
        'contact_email',
        'contact_whatsapp',
        'contact_address',
        'principal_name',
        'principal_title',
        'principal_message',
        'principal_photo',
        'accreditation_grade',
        'accreditation_description',
        'accreditation_valid_until',
        'accreditation_certificate',
        'about_page_title',
        'about_page_description',
        'about_page_mission',
        'about_page_vision',
        'about_page_history',
        'about_page_principal_name',
        'about_page_principal_title',
        'about_page_principal_message',
        'about_page_principal_photo',
        'about_page_school_photo',
        'about_page_organization_chart',
        'about_page_background_image',
        'curriculum_page_background_image',
        'extracurricular_page_background_image',
        'gallery_page_background_image',
        'news_page_background_image',
        'ppdb_page_background_image',
        'about_page_achievements',
        'about_page_facilities_description',
        'organization_structure_title',
        'organization_structure_description',
        'organization_structure_image',
        'library_structure_image',
        'library_operational_hours_weekdays',
        'library_operational_hours_saturday',
        'library_location',
        'library_email',
        'library_phone',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the active homepage setting.
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first() ?? static::first();
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/logo.png');
    }

    /**
     * Get the school image URL.
     */
    public function getSchoolImageUrlAttribute()
    {
        if ($this->school_image) {
            // Always use local URL for now
            return asset('storage/' . $this->school_image);
        }
        return asset('images/placeholder-school.jpg');
    }

    /**
     * Get the hero background image URL.
     */
    public function getHeroBackgroundImageUrlAttribute()
    {
        if ($this->hero_background_image) {
            $url = asset('storage/' . $this->hero_background_image);
            // Add cache busting parameter
            $separator = strpos($url, '?') !== false ? '&' : '?';
            return $url . $separator . 'v=' . time();
        }
        return asset('images/placeholders/placeholder-hero-background.jpg');
    }

    /**
     * Get the principal photo URL.
     */
    public function getPrincipalPhotoUrlAttribute()
    {
        return $this->principal_photo ? asset('storage/' . $this->principal_photo) : asset('images/placeholder-principal.jpg');
    }

    /**
     * Get the accreditation certificate URL.
     */
    public function getAccreditationCertificateUrlAttribute()
    {
        return $this->accreditation_certificate ? asset('storage/' . $this->accreditation_certificate) : asset('images/placeholder-certificate.jpg');
    }

    /**
     * Get the about page principal photo URL.
     */
    public function getAboutPagePrincipalPhotoUrlAttribute()
    {
        return $this->about_page_principal_photo ? asset('storage/' . $this->about_page_principal_photo) : asset('images/placeholder-principal.jpg');
    }

    /**
     * Get the about page school photo URL.
     */
    public function getAboutPageSchoolPhotoUrlAttribute()
    {
        return $this->about_page_school_photo ? asset('storage/' . $this->about_page_school_photo) : asset('images/placeholder-school.jpg');
    }

    /**
     * Get the about page organization chart URL.
     */
    public function getAboutPageOrganizationChartUrlAttribute()
    {
        return $this->about_page_organization_chart ? asset('storage/' . $this->about_page_organization_chart) : asset('images/placeholder-org-chart.jpg');
    }

    /**
     * Get the about page background image URL.
     */
    public function getAboutPageBackgroundImageUrlAttribute()
    {
        if ($this->about_page_background_image) {
            $url = asset('storage/' . $this->about_page_background_image);
            // Add cache busting parameter
            $separator = strpos($url, '?') !== false ? '&' : '?';
            return $url . $separator . 'v=' . time();
        }
        return asset('images/placeholders/placeholder-about-background.jpg');
    }

    /**
     * Get the curriculum page background image URL.
     */
    public function getCurriculumPageBackgroundImageUrlAttribute()
    {
        return $this->curriculum_page_background_image ? asset('storage/' . $this->curriculum_page_background_image) : asset('images/placeholders/placeholder-curriculum-background.jpg');
    }

    /**
     * Get the extracurricular page background image URL.
     */
    public function getExtracurricularPageBackgroundImageUrlAttribute()
    {
        return $this->extracurricular_page_background_image ? asset('storage/' . $this->extracurricular_page_background_image) : asset('images/placeholders/placeholder-extracurricular-background.jpg');
    }

    /**
     * Get the gallery page background image URL.
     */
    public function getGalleryPageBackgroundImageUrlAttribute()
    {
        return $this->gallery_page_background_image ? asset('storage/' . $this->gallery_page_background_image) : asset('images/placeholders/placeholder-gallery-background.jpg');
    }

    /**
     * Get the news page background image URL.
     */
    public function getNewsPageBackgroundImageUrlAttribute()
    {
        return $this->news_page_background_image ? asset('storage/' . $this->news_page_background_image) : asset('images/placeholders/placeholder-news-background.jpg');
    }

    /**
     * Get the PPDB page background image URL.
     */
    public function getPpdbPageBackgroundImageUrlAttribute()
    {
        return $this->ppdb_page_background_image ? asset('storage/' . $this->ppdb_page_background_image) : asset('images/placeholders/placeholder-ppdb-background.jpg');
    }

    /**
     * Get the organization structure image URL.
     */
    public function getOrganizationStructureImageUrlAttribute()
    {
        return $this->organization_structure_image ? asset('storage/' . $this->organization_structure_image) : asset('images/placeholder-organization-chart.jpg');
    }

    public function getLibraryStructureImageUrlAttribute()
    {
        return $this->library_structure_image ? asset('storage/' . $this->library_structure_image) : asset('images/STRUKTUR ORGANISASI PERPUSTAKAAN.png');
    }
}
