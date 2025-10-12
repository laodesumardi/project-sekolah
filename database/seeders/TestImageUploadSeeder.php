<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TestImageUploadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Testing image upload process...');
        
        // Test creating a simple image
        $imageName = 'test-' . time() . '.jpg';
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
        imagestring($image, 5, 120, 140, 'Test Image', $textColor);
        
        // Save the image
        if (imagejpeg($image, $imagePath, 80)) {
            $this->command->info("Test image created successfully: {$imagePath}");
            
            // Check if file exists
            if (file_exists($imagePath)) {
                $this->command->info("File exists and is readable");
                
                // Test file size
                $fileSize = filesize($imagePath);
                $this->command->info("File size: {$fileSize} bytes");
                
                // Test if file is accessible via URL
                $url = asset('storage/news/' . $imageName);
                $this->command->info("Image URL: {$url}");
                
                // Clean up test file
                unlink($imagePath);
                $this->command->info("Test file cleaned up");
            } else {
                $this->command->error("File not found after creation");
            }
        } else {
            $this->command->error("Failed to create test image");
        }
        
        imagedestroy($image);
        
        $this->command->info('Image upload test completed');
    }
}
