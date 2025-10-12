<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CleanAndFixNewsImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all news
        $allNews = News::all();

        foreach ($allNews as $news) {
            $this->command->info("Processing news: {$news->title}");
            
            // Check if current image exists
            $currentImagePath = null;
            if ($news->image) {
                $currentImagePath = storage_path('app/public/news/' . $news->image);
                if (!file_exists($currentImagePath)) {
                    $this->command->info("Current image not found: {$news->image}");
                } else {
                    $this->command->info("Current image exists: {$news->image}");
                    continue;
                }
            }

            // Create a new image
            $imageName = 'news-' . $news->id . '-' . time() . '.jpg';
            $newImagePath = storage_path('app/public/news/' . $imageName);
            
            // Create a simple colored rectangle as placeholder
            $image = imagecreate(400, 300);
            $bgColor = imagecolorallocate($image, 59, 130, 246); // Blue background
            $textColor = imagecolorallocate($image, 255, 255, 255); // White text
            
            imagefill($image, 0, 0, $bgColor);
            
            // Add some simple shapes
            $rectColor = imagecolorallocate($image, 37, 99, 235);
            imagefilledrectangle($image, 50, 50, 350, 250, $rectColor);
            
            // Add text
            imagestring($image, 5, 120, 140, 'News Image', $textColor);
            
            // Save the image
            if (imagejpeg($image, $newImagePath, 80)) {
                // Update the news record
                $news->update(['image' => $imageName]);
                $this->command->info("Created new image: {$imageName}");
                
                // Test the image URL
                $imageUrl = $news->fresh()->image_url;
                $this->command->info("Image URL: {$imageUrl}");
                
                // Verify the file exists
                if (file_exists($newImagePath)) {
                    $this->command->info("File verified: {$newImagePath}");
                } else {
                    $this->command->error("File not found after creation: {$newImagePath}");
                }
            } else {
                $this->command->error("Failed to create image for: {$news->title}");
            }
            
            imagedestroy($image);
        }

        $this->command->info('Fixed images for ' . $allNews->count() . ' news articles');
    }
}
