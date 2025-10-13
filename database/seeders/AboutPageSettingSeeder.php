<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutPageSetting;

class AboutPageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutPageSetting::create([
            'page_title' => 'Tentang Kami',
            'description' => 'SMP Negeri 01 Namrole adalah lembaga pendidikan menengah pertama yang berdiri sejak tahun 1985. Kami berkomitmen untuk memberikan pendidikan berkualitas tinggi yang mengintegrasikan aspek akademik, karakter, dan keterampilan hidup untuk membentuk generasi yang unggul dan berakhlak mulia.',
            'mission' => '1. Menyelenggarakan pendidikan yang berkualitas dan berkarakter\n2. Mengembangkan potensi siswa secara optimal\n3. Membentuk generasi yang berakhlak mulia dan berprestasi\n4. Menciptakan lingkungan belajar yang kondusif dan menyenangkan\n5. Membangun kemitraan yang harmonis dengan orang tua dan masyarakat',
            'vision' => 'Terwujudnya sekolah yang unggul dalam prestasi, berkarakter, dan berakhlak mulia',
            'history' => 'SMP Negeri 01 Namrole didirikan pada tahun 1985 sebagai salah satu sekolah menengah pertama di Kabupaten Buru Selatan. Sejak berdiri, sekolah ini telah mengalami perkembangan yang signifikan dalam hal fasilitas, kualitas pendidikan, dan prestasi siswa. Sekolah ini telah meluluskan ribuan siswa yang berhasil melanjutkan pendidikan ke jenjang yang lebih tinggi dan berkontribusi positif bagi masyarakat.',
            'principal_name' => 'MUHAMMAD SAID BUTON, SH',
            'principal_title' => 'Kepala Sekolah',
            'principal_message' => 'Selamat datang di SMP Negeri 01 Namrole. Sebagai kepala sekolah, saya berkomitmen untuk memimpin sekolah ini menuju keunggulan dalam pendidikan. Kami akan terus berupaya memberikan yang terbaik bagi siswa-siswi kami dengan dukungan tenaga pendidik yang profesional dan fasilitas yang memadai.',
            'achievements' => '1. Juara 1 Lomba Cerdas Cermat Tingkat Kabupaten (2023)\n2. Juara 2 Olimpiade Matematika Tingkat Provinsi (2023)\n3. Juara 1 Lomba Pidato Bahasa Indonesia Tingkat Kabupaten (2022)\n4. Sekolah Adiwiyata Tingkat Kabupaten (2022)\n5. Akreditasi A dengan nilai 95 (2021)',
            'facilities_description' => 'SMP Negeri 01 Namrole dilengkapi dengan fasilitas modern yang mendukung proses pembelajaran, termasuk laboratorium komputer, laboratorium IPA, perpustakaan digital, ruang multimedia, lapangan olahraga, dan kantin sehat. Semua fasilitas ini dikelola dengan standar yang tinggi untuk memastikan kenyamanan dan keamanan siswa.',
            'contact_phone' => '(021) 1234-5678',
            'contact_email' => 'info@smpn01namrole.sch.id',
            'contact_address' => 'Jl. Pendidikan No. 123, Namrole, Kabupaten Buru Selatan, Maluku',
            'website' => 'https://smpn01namrole.sch.id',
            'is_active' => true,
        ]);
    }
}
