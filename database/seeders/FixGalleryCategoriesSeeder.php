<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class FixGalleryCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Fixing gallery categories...');
        
        // Update old categories to new ones
        $categoryMappings = [
            'Kegiatan' => 'activities',
            'Fasilitas' => 'facilities',
            'Prestasi' => 'other',
            'Event' => 'events',
            'General' => 'other',
        ];
        
        foreach ($categoryMappings as $oldCategory => $newCategory) {
            $count = Gallery::where('category', $oldCategory)->count();
            if ($count > 0) {
                Gallery::where('category', $oldCategory)->update(['category' => $newCategory]);
                $this->command->info("Updated {$count} galleries from '{$oldCategory}' to '{$newCategory}'");
            }
        }
        
        $this->command->info('Gallery categories fixed successfully');
    }
}
