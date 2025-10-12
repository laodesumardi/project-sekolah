<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FixGalleryImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure directories exist
        if (!Storage::exists('public/gallery')) {
            Storage::makeDirectory('public/gallery');
        }
        if (!Storage::exists('public/gallery/thumbnails')) {
            Storage::makeDirectory('public/gallery/thumbnails');
        }

        // Get all galleries
        $allGalleries = Gallery::all();

        foreach ($allGalleries as $gallery) {
            $this->command->info("Processing gallery: {$gallery->title}");
            
            // Check if current image exists
            $currentImagePath = null;
            if ($gallery->image) {
                $currentImagePath = storage_path('app/public/gallery/' . $gallery->image);
                if (file_exists($currentImagePath)) {
                    $this->command->info("Current image exists: {$gallery->image}");
                    
                    // Check if thumbnail exists
                    if ($gallery->thumbnail) {
                        $thumbnailPath = storage_path('app/public/gallery/thumbnails/' . $gallery->thumbnail);
                        if (file_exists($thumbnailPath)) {
                            $this->command->info("Thumbnail exists: {$gallery->thumbnail}");
                            continue;
                        } else {
                            $this->command->info("Thumbnail not found: {$gallery->thumbnail}");
                        }
                    }
                    
                    // Create thumbnail from existing image
                    $thumbnailName = 'thumb_' . $gallery->image;
                    $sourcePath = $currentImagePath;
                    $destPath = storage_path('app/public/gallery/thumbnails/' . $thumbnailName);
                    
                    // Ensure thumbnails directory exists
                    $thumbnailsDir = storage_path('app/public/gallery/thumbnails');
                    if (!file_exists($thumbnailsDir)) {
                        mkdir($thumbnailsDir, 0755, true);
                    }
                    
                    if (copy($sourcePath, $destPath)) {
                        $gallery->update(['thumbnail' => $thumbnailName]);
                        $this->command->info("Created thumbnail: {$thumbnailName}");
                    } else {
                        $this->command->error("Failed to create thumbnail for: {$gallery->title}");
                    }
                    continue;
                } else {
                    $this->command->info("Current image not found: {$gallery->image}");
                }
            }

            // Create a new image
            $imageName = 'gallery-' . $gallery->id . '-' . time() . '.jpg';
            $newImagePath = storage_path('app/public/gallery/' . $imageName);
            
            // Ensure directory exists
            $galleryDir = storage_path('app/public/gallery');
            if (!file_exists($galleryDir)) {
                mkdir($galleryDir, 0755, true);
            }
            
            // Create a simple colored rectangle as placeholder
            $image = imagecreate(400, 300);
            $bgColor = imagecolorallocate($image, 59, 130, 246); // Blue background
            $textColor = imagecolorallocate($image, 255, 255, 255); // White text
            
            imagefill($image, 0, 0, $bgColor);
            
            // Add some simple shapes
            $rectColor = imagecolorallocate($image, 37, 99, 235);
            imagefilledrectangle($image, 50, 50, 350, 250, $rectColor);
            
            // Add text
            imagestring($image, 5, 120, 140, 'Gallery Image', $textColor);
            
            // Save the image
            if (imagejpeg($image, $newImagePath, 80)) {
                // Update the gallery record
                $gallery->update(['image' => $imageName]);
                $this->command->info("Created new image: {$imageName}");
                
                // Create thumbnail
                $thumbnailName = 'thumb_' . $imageName;
                $thumbnailPath = storage_path('app/public/gallery/thumbnails/' . $thumbnailName);
                
                // Ensure thumbnails directory exists
                $thumbnailsDir = storage_path('app/public/gallery/thumbnails');
                if (!file_exists($thumbnailsDir)) {
                    mkdir($thumbnailsDir, 0755, true);
                }
                
                if (copy($newImagePath, $thumbnailPath)) {
                    $gallery->update(['thumbnail' => $thumbnailName]);
                    $this->command->info("Created thumbnail: {$thumbnailName}");
                } else {
                    $this->command->error("Failed to create thumbnail for: {$gallery->title}");
                }
            } else {
                $this->command->error("Failed to create image for: {$gallery->title}");
            }
            
            imagedestroy($image);
        }

        $this->command->info('Fixed images for ' . $allGalleries->count() . ' galleries');
    }
}
