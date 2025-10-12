<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class EnsureGalleryDirectoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Ensuring gallery directories exist...');
        
        // Create necessary directories
        $directories = [
            'public/gallery',
            'public/gallery/thumbnails',
        ];
        
        foreach ($directories as $dir) {
            if (!Storage::exists($dir)) {
                Storage::makeDirectory($dir);
                $this->command->info("Created directory: {$dir}");
            } else {
                $this->command->info("Directory exists: {$dir}");
            }
        }
        
        $this->command->info('Gallery directories ensured');
    }
}
