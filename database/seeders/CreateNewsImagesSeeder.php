<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class CreateNewsImagesSeeder extends Seeder
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
            // Skip if already has image
            if ($news->image && Storage::exists('public/news/' . $news->image)) {
                continue;
            }

            // Create a simple placeholder image
            $imageName = 'news-' . $news->id . '.jpg';
            $imagePath = storage_path('app/public/news/' . $imageName);
            
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
            imagejpeg($image, $imagePath, 80);
            imagedestroy($image);
            
            // Update the news record
            $news->update(['image' => $imageName]);
            
            $this->command->info("Created image for news: {$news->title}");
        }

        $this->command->info('Created images for ' . $allNews->count() . ' news articles');
    }
}
