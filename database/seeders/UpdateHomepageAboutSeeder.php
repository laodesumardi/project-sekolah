<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomepageSetting;

class UpdateHomepageAboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homepageSetting = HomepageSetting::first();
        
        if ($homepageSetting) {
            $homepageSetting->update([
                'about_page_title' => 'Tentang Kami',
                'about_page_description' => 'SMP Negeri 01 Namrole adalah institusi pendidikan yang berdedikasi untuk mengembangkan potensi siswa dan membentuk karakter yang unggul.',
                'about_page_vision' => 'Terwujudnya sekolah yang unggul dalam prestasi, berkarakter, dan berakhlak mulia',
                'about_page_mission' => '1. Menyelenggarakan pendidikan yang berkualitas dan berkarakter
2. Mengembangkan potensi siswa secara optimal
3. Membentuk generasi yang berakhlak mulia dan berprestasi
4. Menciptakan lingkungan belajar yang kondusif dan menyenangkan',
                'about_page_history' => 'SMP Negeri 01 Namrole didirikan pada tahun 1985 dengan visi untuk memberikan pendidikan berkualitas bagi masyarakat Namrole dan sekitarnya. Selama lebih dari 35 tahun, sekolah ini telah menghasilkan ribuan lulusan yang berhasil di berbagai bidang.',
                'about_page_principal_name' => 'MUHAMMAD SAID BUTON, SH',
                'about_page_principal_title' => 'Kepala Sekolah',
                'about_page_principal_message' => 'Sebagai kepala sekolah, saya berkomitmen untuk terus meningkatkan kualitas pendidikan dan menciptakan lingkungan belajar yang kondusif bagi semua siswa.',
                'about_page_achievements' => '• Juara 1 Olimpiade Matematika Tingkat Kabupaten 2023
• Juara 2 Lomba Cerdas Cermat Tingkat Provinsi 2023
• Juara 1 Festival Seni dan Budaya Tingkat Kabupaten 2023
• Akreditasi A dari BAN-S/M 2023',
                'about_page_facilities_description' => 'Sekolah dilengkapi dengan fasilitas modern termasuk laboratorium komputer, laboratorium IPA, perpustakaan digital, lapangan olahraga, dan ruang kelas yang nyaman dengan AC.',
            ]);
            
            echo "HomepageSetting updated successfully!\n";
        } else {
            echo "No HomepageSetting found!\n";
        }
    }
}
