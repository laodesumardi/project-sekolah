<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FixAllNewsImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create storage directory if it doesn't exist
        if (!Storage::exists('public/news')) {
            Storage::makeDirectory('public/news');
        }

        // Get all news
        $allNews = News::all();

        foreach ($allNews as $news) {
            $imagePath = storage_path('app/public/news/' . $news->image);
            
            // Check if image exists
            if ($news->image && file_exists($imagePath)) {
                $this->command->info("Image exists for news: {$news->title}");
                continue;
            }

            // Create a new image if it doesn't exist
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
                $this->command->info("Created new image for news: {$news->title}");
            } else {
                $this->command->error("Failed to create image for news: {$news->title}");
            }
            
            imagedestroy($image);
        }

        $this->command->info('Fixed images for ' . $allNews->count() . ' news articles');
        
        // Test image URLs
        $this->command->info('Testing image URLs...');
        foreach ($allNews as $news) {
            $url = $news->image_url;
            $this->command->info("News: {$news->title} - Image URL: {$url}");
        }
    }
}