<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomepageSetting;

class HomepageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomepageSetting::create([
            'hero_title' => 'SELAMAT DATANG DI',
            'hero_subtitle' => 'SMP Negeri 01 Namrole',
            'hero_description' => 'Menjadi sekolah unggulan yang membentuk generasi berkarakter, berprestasi, dan berakhlak mulia untuk masa depan yang gemilang.',
            'hero_button_1_text' => 'Daftar Sekarang',
            'hero_button_1_url' => '/ppdb',
            'hero_button_2_text' => 'Pelajari Lebih Lanjut',
            'hero_button_2_url' => '/tentang-kami',
            'school_image' => null, // Akan diupload melalui admin
            'vision_title' => 'Visi Sekolah',
            'vision_description' => 'Terwujudnya sekolah yang unggul dalam prestasi, berkarakter, dan berakhlak mulia',
            'mission_description' => '1. Menyelenggarakan pendidikan yang berkualitas dan berkarakter\n2. Mengembangkan potensi siswa secara optimal\n3. Membentuk generasi yang berakhlak mulia dan berprestasi\n4. Menciptakan lingkungan belajar yang kondusif dan menyenangkan',
            'about_description' => 'SMP Negeri 01 Namrole adalah sekolah menengah pertama yang berkomitmen untuk memberikan pendidikan berkualitas tinggi kepada siswa-siswi. Dengan fasilitas modern, tenaga pengajar yang profesional, dan kurikulum yang komprehensif, kami siap membentuk generasi masa depan yang unggul.',
            'contact_phone' => '(021) 1234-5678',
            'contact_email' => 'info@smpn01namrole.sch.id',
            'contact_address' => 'Jl. Pendidikan No. 123, Namrole, Maluku Tenggara',
            'principal_name' => 'MUHAMMAD SAID BUTON, SH',
            'principal_title' => 'Kepala Sekolah',
            'principal_message' => 'Selamat datang di SMP Negeri 01 Namrole. Sebagai kepala sekolah, saya berkomitmen untuk memimpin sekolah ini menuju keunggulan dalam pendidikan. Kami akan terus berupaya memberikan yang terbaik bagi siswa-siswi kami dengan dukungan tenaga pendidik yang profesional dan fasilitas yang memadai.',
            'accreditation_grade' => 'A',
            'accreditation_description' => 'Predikat sangat baik dalam standar pendidikan nasional',
            'accreditation_valid_until' => '2025',
            'about_page_title' => 'Tentang Kami',
            'about_page_description' => 'SMP Negeri 01 Namrole adalah institusi pendidikan yang berdedikasi untuk mengembangkan potensi siswa dan membentuk karakter yang unggul.',
            'about_page_vision' => 'Terwujudnya sekolah yang unggul dalam prestasi, berkarakter, dan berakhlak mulia',
            'about_page_mission' => '1. Menyelenggarakan pendidikan yang berkualitas dan berkarakter\n2. Mengembangkan potensi siswa secara optimal\n3. Membentuk generasi yang berakhlak mulia dan berprestasi\n4. Menciptakan lingkungan belajar yang kondusif dan menyenangkan',
            'about_page_history' => 'SMP Negeri 01 Namrole didirikan pada tahun 1985 dengan visi untuk memberikan pendidikan berkualitas bagi masyarakat Namrole dan sekitarnya. Selama lebih dari 35 tahun, sekolah ini telah menghasilkan ribuan lulusan yang berhasil di berbagai bidang.',
            'about_page_principal_name' => 'MUHAMMAD SAID BUTON, SH',
            'about_page_principal_title' => 'Kepala Sekolah',
            'about_page_principal_message' => 'Sebagai kepala sekolah, saya berkomitmen untuk terus meningkatkan kualitas pendidikan dan menciptakan lingkungan belajar yang kondusif bagi semua siswa.',
            'about_page_achievements' => '• Juara 1 Olimpiade Matematika Tingkat Kabupaten 2023\n• Juara 2 Lomba Cerdas Cermat Tingkat Provinsi 2023\n• Juara 1 Festival Seni dan Budaya Tingkat Kabupaten 2023\n• Akreditasi A dari BAN-S/M 2023',
            'about_page_facilities_description' => 'Sekolah dilengkapi dengan fasilitas modern termasuk laboratorium komputer, laboratorium IPA, perpustakaan digital, lapangan olahraga, dan ruang kelas yang nyaman dengan AC.',
            'is_active' => true,
        ]);
    }
}
