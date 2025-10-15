<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateFacilitiesSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = \App\Models\Facility::whereNull('slug')->orWhere('slug', '')->get();
        
        foreach ($facilities as $facility) {
            $facility->slug = \Illuminate\Support\Str::slug($facility->name);
            $facility->save();
        }
        
        $this->command->info('Updated ' . $facilities->count() . ' facilities with slug.');
    }
}
