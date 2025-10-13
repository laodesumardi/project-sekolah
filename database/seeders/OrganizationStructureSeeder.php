<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomepageSetting;

class OrganizationStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homepageSetting = HomepageSetting::first();
        
        if ($homepageSetting) {
            $homepageSetting->organization_structure_title = 'Struktur Organisasi SMP Negeri 01 Namrole';
            $homepageSetting->organization_structure_description = 'Struktur organisasi yang jelas dan terorganisir untuk memastikan kelancaran proses pendidikan dan administrasi sekolah.';
            $homepageSetting->organization_structure_image = 'organization-structure.jpg';
            $homepageSetting->save();
            
            $this->command->info('Organization structure data added successfully!');
        } else {
            $this->command->warn('No HomepageSetting found to update.');
        }
    }
}