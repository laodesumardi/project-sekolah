<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPageSetting extends Model
{
    protected $fillable = [
        'page_title',
        'description',
        'mission',
        'vision',
        'history',
        'principal_name',
        'principal_title',
        'principal_message',
        'principal_photo',
        'school_photo',
        'organization_chart',
        'achievements',
        'facilities_description',
        'contact_phone',
        'contact_email',
        'contact_address',
        'website',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the active about page setting.
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first() ?? static::first();
    }

    /**
     * Get the principal photo URL.
     */
    public function getPrincipalPhotoUrlAttribute()
    {
        return $this->principal_photo ? asset('storage/' . $this->principal_photo) : asset('images/placeholder-principal.jpg');
    }

    /**
     * Get the school photo URL.
     */
    public function getSchoolPhotoUrlAttribute()
    {
        return $this->school_photo ? asset('storage/' . $this->school_photo) : asset('images/placeholder-school.jpg');
    }

    /**
     * Get the organization chart URL.
     */
    public function getOrganizationChartUrlAttribute()
    {
        return $this->organization_chart ? asset('storage/' . $this->organization_chart) : asset('images/placeholder-org-chart.jpg');
    }
}
