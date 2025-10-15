<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomepageSetting;

class HomepageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create or update homepage setting
        $homepageSetting = HomepageSetting::firstOrCreate(
            ['is_active' => true],
            [
                'hero_title' => 'Selamat Datang di',
                'hero_subtitle' => 'SMP Negeri 01 Namrole',
                'hero_description' => 'Menjadi sekolah unggulan yang membentuk generasi berkarakter, berprestasi, dan berakhlak mulia untuk masa depan yang gemilang.',
                'hero_button_1_text' => 'Daftar Sekarang',
                'hero_button_1_url' => '/ppdb',
                'hero_button_2_text' => 'Pelajari Lebih Lanjut',
                'hero_button_2_url' => '/tentang-kami',
                'contact_phone' => '(0913) 1234567',
                'contact_email' => 'info@smpn01namrole.sch.id',
                'contact_address' => 'Jl. Pendidikan No. 1, Namrole, Buru Selatan',
                'principal_name' => 'Dr. Ahmad Suryadi, M.Pd.',
                'principal_title' => 'Kepala Sekolah',
                'principal_message' => 'Selamat datang di SMP Negeri 01 Namrole. Kami berkomitmen untuk memberikan pendidikan terbaik bagi generasi muda.',
                'accreditation_grade' => 'A',
                'accreditation_description' => 'Sekolah dengan akreditasi A yang menunjukkan kualitas pendidikan yang sangat baik.',
                'accreditation_valid_until' => '2027',
                'about_page_title' => 'Tentang Kami',
                'about_page_description' => 'Mengenal lebih dekat SMP Negeri 01 Namrole',
                'about_page_vision' => 'Menjadi sekolah unggulan yang menghasilkan lulusan berkarakter, berprestasi, dan berdaya saing global',
                'about_page_mission' => '1. Menyelenggarakan pendidikan yang berkualitas tinggi\n2. Membentuk karakter siswa yang berakhlak mulia\n3. Mengembangkan potensi siswa secara optimal\n4. Menciptakan lingkungan belajar yang kondusif',
                'about_page_history' => 'SMP Negeri 01 Namrole didirikan pada tahun 1985 dan telah menjadi salah satu sekolah unggulan di Kabupaten Buru Selatan.',
                'about_page_principal_name' => 'Dr. Ahmad Suryadi, M.Pd.',
                'about_page_principal_title' => 'Kepala Sekolah',
                'about_page_principal_message' => 'Kami berkomitmen untuk memberikan pendidikan terbaik bagi generasi muda Indonesia.',
                'organization_structure_title' => 'Struktur Organisasi',
                'organization_structure_description' => 'Struktur organisasi sekolah yang solid untuk mendukung proses pembelajaran yang optimal.',
                'library_operational_hours_weekdays' => 'Senin - Jumat: 08.00 - 16.00',
                'library_operational_hours_saturday' => 'Sabtu: 08.00 - 12.00',
                'library_location' => 'Gedung Perpustakaan Lantai 2',
                'library_email' => 'perpustakaan@smpn01namrole.sch.id',
                'library_phone' => '(0913) 1234568',
                'is_active' => true,
            ]
        );

        $this->command->info('HomepageSetting created/updated successfully!');
    }
}