<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get image URL with fallback
     */
    public static function getImageUrl($path, $fallback = null)
    {
        if (empty($path)) {
            return $fallback ?: asset('images/placeholder-image.jpg');
        }

        // Check if it's a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Check if file exists in public directory
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // Check if file exists in storage
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        // Return fallback
        return $fallback ?: asset('images/placeholder-image.jpg');
    }

    /**
     * Get logo URL with fallback
     */
    public static function getLogoUrl()
    {
        $logoPaths = [
            'logo.png',
            'images/logos/logo.png',
            'images/logos/logo.svg',
            'images/placeholder-image.jpg'
        ];

        foreach ($logoPaths as $path) {
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return asset('images/placeholder-image.jpg');
    }

    /**
     * Get favicon URL
     */
    public static function getFaviconUrl()
    {
        $faviconPaths = [
            'favicon.ico',
            'logo.png',
            'images/logos/logo.png'
        ];

        foreach ($faviconPaths as $path) {
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return asset('favicon.ico');
    }

    /**
     * Check if image exists
     */
    public static function imageExists($path)
    {
        if (empty($path)) {
            return false;
        }

        // Check if it's a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return true;
        }

        // Check if file exists in public directory
        if (file_exists(public_path($path))) {
            return true;
        }

        // Check if file exists in storage
        if (Storage::disk('public')->exists($path)) {
            return true;
        }

        return false;
    }
}
