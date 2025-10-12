<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FinalFixAllGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all galleries
        $allGalleries = Gallery::all();

        foreach ($allGalleries as $gallery) {
            $this->command->info("Final fix for gallery: {$gallery->title}");
            
            // Create new image and thumbnail
            $imageName = 'gallery-' . $gallery->id . '-' . time() . '.jpg';
            $thumbnailName = 'thumb-gallery-' . $gallery->id . '-' . time() . '.jpg';
            
            $newImagePath = storage_path('app/public/gallery/' . $imageName);
            $newThumbnailPath = storage_path('app/public/gallery/thumbnails/' . $thumbnailName);
            
            // Ensure directories exist
            $galleryDir = storage_path('app/public/gallery');
            $thumbnailsDir = storage_path('app/public/gallery/thumbnails');
            
            if (!file_exists($galleryDir)) {
                mkdir($galleryDir, 0755, true);
            }
            
            if (!file_exists($thumbnailsDir)) {
                mkdir($thumbnailsDir, 0755, true);
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
            
            // Save the main image
            if (imagejpeg($image, $newImagePath, 80)) {
                // Create thumbnail (smaller version)
                $thumbnail = imagecreate(200, 150);
                imagecopyresized($thumbnail, $image, 0, 0, 0, 0, 200, 150, 400, 300);
                
                if (imagejpeg($thumbnail, $newThumbnailPath, 80)) {
                    // Update the gallery record
                    $gallery->update([
                        'image' => $imageName,
                        'thumbnail' => $thumbnailName
                    ]);
                    
                    $this->command->info("Created new image: {$imageName}");
                    $this->command->info("Created thumbnail: {$thumbnailName}");
                    
                    // Test the URLs
                    $imageUrl = $gallery->fresh()->image_url;
                    $thumbnailUrl = $gallery->fresh()->thumbnail_url;
                    
                    $this->command->info("Image URL: {$imageUrl}");
                    $this->command->info("Thumbnail URL: {$thumbnailUrl}");
                    
                    // Verify the files exist
                    if (file_exists($newImagePath) && file_exists($newThumbnailPath)) {
                        $this->command->info("Files verified successfully");
                        
                        // Test if URLs are accessible
                        $imageTest = file_get_contents($imageUrl) ? 'SUCCESS' : 'FAILED';
                        $thumbnailTest = file_get_contents($thumbnailUrl) ? 'SUCCESS' : 'FAILED';
                        
                        $this->command->info("Image URL test: {$imageTest}");
                        $this->command->info("Thumbnail URL test: {$thumbnailTest}");
                    } else {
                        $this->command->error("Files not found after creation");
                    }
                } else {
                    $this->command->error("Failed to create thumbnail for: {$gallery->title}");
                }
            } else {
                $this->command->error("Failed to create image for: {$gallery->title}");
            }
            
            imagedestroy($image);
            if (isset($thumbnail)) {
                imagedestroy($thumbnail);
            }
        }

        $this->command->info('Final fix completed for ' . $allGalleries->count() . ' gallery items');
    }
}
