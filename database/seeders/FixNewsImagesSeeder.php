<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class FixNewsImagesSeeder extends Seeder
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

        // Get all news without images
        $newsWithoutImages = News::whereNull('image')->orWhere('image', '')->get();

        foreach ($newsWithoutImages as $news) {
            // Create a simple placeholder image
            $imageName = 'news-' . $news->id . '.jpg';
            $imagePath = storage_path('app/public/news/' . $imageName);
            
            // Create a simple colored rectangle as placeholder
            $image = imagecreate(400, 300);
            $bgColor = imagecolorallocate($image, 243, 244, 246); // Light gray
            $textColor = imagecolorallocate($image, 107, 114, 128); // Gray text
            
            imagefill($image, 0, 0, $bgColor);
            
            // Add some simple shapes
            $rectColor = imagecolorallocate($image, 156, 163, 175);
            imagefilledrectangle($image, 50, 50, 350, 250, $rectColor);
            
            // Add text
            imagestring($image, 5, 150, 140, 'News Image', $textColor);
            
            // Save the image
            imagejpeg($image, $imagePath, 80);
            imagedestroy($image);
            
            // Update the news record
            $news->update(['image' => $imageName]);
            
            $this->command->info("Created image for news: {$news->title}");
        }

        $this->command->info('Fixed images for ' . $newsWithoutImages->count() . ' news articles');
    }
}
