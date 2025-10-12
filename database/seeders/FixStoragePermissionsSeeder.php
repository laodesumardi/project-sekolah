<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FixStoragePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Fixing storage permissions...');
        
        // Create necessary directories
        $directories = [
            storage_path('app/public'),
            storage_path('app/public/news'),
            storage_path('app/public/news/thumbnails'),
            storage_path('app/public/galleries'),
            storage_path('app/public/facilities'),
        ];
        
        foreach ($directories as $dir) {
            if (!file_exists($dir)) {
                if (mkdir($dir, 0755, true)) {
                    $this->command->info("Created directory: {$dir}");
                } else {
                    $this->command->error("Failed to create directory: {$dir}");
                }
            } else {
                $this->command->info("Directory exists: {$dir}");
            }
            
            // Check if writable
            if (is_writable($dir)) {
                $this->command->info("Directory is writable: {$dir}");
            } else {
                $this->command->error("Directory is NOT writable: {$dir}");
            }
        }
        
        // Test file creation
        $testFile = storage_path('app/public/news/test.txt');
        if (file_put_contents($testFile, 'test')) {
            $this->command->info("Test file created successfully");
            unlink($testFile);
        } else {
            $this->command->error("Failed to create test file");
        }
        
        $this->command->info('Storage permissions check completed');
    }
}
