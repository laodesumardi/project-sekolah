<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomepageSetting;

class LibraryInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homepageSetting = HomepageSetting::first();
        
        if ($homepageSetting) {
            $homepageSetting->update([
                'library_operational_hours_weekdays' => 'Senin - Jumat: 07.00 - 15.00 WIT',
                'library_operational_hours_saturday' => 'Sabtu: 08.00 - 12.00 WIT',
                'library_location' => 'Gedung Perpustakaan, SMP Negeri 01 Namrole',
                'library_email' => 'perpustakaan@smpn01namrole.sch.id',
                'library_phone' => '(0913) 123456'
            ]);
            
            $this->command->info('Library information seeded successfully!');
        } else {
            $this->command->warn('No HomepageSetting found to update.');
        }
    }
}