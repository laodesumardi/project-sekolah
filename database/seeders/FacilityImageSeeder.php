<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;
use Illuminate\Support\Facades\Storage;

class FacilityImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = Facility::all();
        
        foreach ($facilities as $facility) {
            if (!$facility->image) {
                // Set placeholder image based on facility name
                $imageName = $this->getPlaceholderImage($facility->name);
                $facility->image = $imageName;
                $facility->save();
                
                $this->command->info("Added placeholder image for: {$facility->name}");
            }
        }
    }
    
    private function getPlaceholderImage($facilityName)
    {
        $name = strtolower($facilityName);
        
        if (strpos($name, 'komputer') !== false || strpos($name, 'computer') !== false) {
            return 'computer-lab.jpg';
        } elseif (strpos($name, 'ipa') !== false || strpos($name, 'science') !== false) {
            return 'science-lab.jpg';
        } elseif (strpos($name, 'perpustakaan') !== false || strpos($name, 'library') !== false) {
            return 'library.jpg';
        } elseif (strpos($name, 'olahraga') !== false || strpos($name, 'sport') !== false) {
            return 'sports-hall.jpg';
        } elseif (strpos($name, 'aula') !== false || strpos($name, 'hall') !== false) {
            return 'auditorium.jpg';
        } elseif (strpos($name, 'kantin') !== false || strpos($name, 'canteen') !== false) {
            return 'canteen.jpg';
        } elseif (strpos($name, 'kelas') !== false || strpos($name, 'class') !== false) {
            return 'classroom.jpg';
        } elseif (strpos($name, 'masjid') !== false || strpos($name, 'mosque') !== false) {
            return 'mosque.jpg';
        } else {
            return 'facility-default.jpg';
        }
    }
}