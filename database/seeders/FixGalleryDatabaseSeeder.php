<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FixGalleryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all galleries
        $allGalleries = Gallery::all();

        foreach ($allGalleries as $gallery) {
            $this->command->info("Fixing gallery: {$gallery->title}");
            
            // Check what files actually exist
            $galleryDir = storage_path('app/public/gallery');
            $thumbnailsDir = storage_path('app/public/gallery/thumbnails');
            
            $existingFiles = glob($galleryDir . '/gallery-' . $gallery->id . '-*.jpg');
            $existingThumbnails = glob($thumbnailsDir . '/thumb-gallery-' . $gallery->id . '-*.jpg');
            
            if (!empty($existingFiles) && !empty($existingThumbnails)) {
                $imageFile = basename($existingFiles[0]);
                $thumbnailFile = basename($existingThumbnails[0]);
                
                $this->command->info("Found existing files:");
                $this->command->info("Image: {$imageFile}");
                $this->command->info("Thumbnail: {$thumbnailFile}");
                
                // Update the database with the correct file names
                $gallery->update([
                    'image' => $imageFile,
                    'thumbnail' => $thumbnailFile
                ]);
                
                $this->command->info("Updated database with correct file names");
                
                // Test the URLs
                $imageUrl = $gallery->fresh()->image_url;
                $thumbnailUrl = $gallery->fresh()->thumbnail_url;
                
                $this->command->info("Image URL: {$imageUrl}");
                $this->command->info("Thumbnail URL: {$thumbnailUrl}");
                
                // Verify the files exist
                $imagePath = storage_path('app/public/gallery/' . $imageFile);
                $thumbnailPath = storage_path('app/public/gallery/thumbnails/' . $thumbnailFile);
                
                if (file_exists($imagePath) && file_exists($thumbnailPath)) {
                    $this->command->info("Files verified successfully");
                } else {
                    $this->command->error("Files not found after update");
                }
            } else {
                $this->command->error("No existing files found for gallery {$gallery->id}");
            }
        }

        $this->command->info('Fixed database for ' . $allGalleries->count() . ' gallery items');
    }
}
