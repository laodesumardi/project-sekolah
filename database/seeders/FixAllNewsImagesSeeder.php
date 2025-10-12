<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Str;

class FixAllNewsImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create news directory if not exists
        if (!file_exists(storage_path('app/public/news'))) {
            mkdir(storage_path('app/public/news'), 0755, true);
        }

        // Create thumbnails directory if not exists
        if (!file_exists(storage_path('app/public/news/thumbnails'))) {
            mkdir(storage_path('app/public/news/thumbnails'), 0755, true);
        }

        // Get all news
        $news = News::all();
        
        foreach ($news as $index => $article) {
            // Create a unique image name
            $imageName = time() . '_' . Str::slug($article->title) . '.jpg';
            
            // Create a simple colored rectangle as placeholder
            $imageContent = $this->createPlaceholderImage($article->title, $index);
            
            // Save the image
            file_put_contents(storage_path('app/public/news/' . $imageName), $imageContent);
            
            // Create thumbnail
            $thumbnailName = 'thumb_' . $imageName;
            file_put_contents(storage_path('app/public/news/thumbnails/' . $thumbnailName), $imageContent);
            
            // Update the news record
            $article->update(['image' => $imageName]);
            
            $this->command->info("Created image for: {$article->title} -> {$imageName}");
        }
    }

    /**
     * Create a simple placeholder image with different colors
     */
    private function createPlaceholderImage($title, $index)
    {
        $colors = [
            '#3B82F6', // Blue
            '#10B981', // Green
            '#F59E0B', // Yellow
            '#EF4444', // Red
            '#8B5CF6', // Purple
            '#06B6D4', // Cyan
            '#84CC16', // Lime
        ];
        
        $color = $colors[$index % count($colors)];
        
        // Create a simple SVG placeholder
        $svg = '<?xml version="1.0" encoding="UTF-8"?>
        <svg width="400" height="300" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">
            <rect width="400" height="300" fill="#f3f4f6"/>
            <rect x="50" y="50" width="300" height="200" fill="' . $color . '" rx="8"/>
            <text x="200" y="140" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="16" font-weight="bold">' . Str::limit($title, 20) . '</text>
            <text x="200" y="170" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="12">News Image</text>
        </svg>';
        
        return $svg;
    }
}

