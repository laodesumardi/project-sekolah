<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $this->command->warn('Admin user not found. Please run UserSeeder first.');
            return;
        }

        // Get news categories
        $categories = NewsCategory::all();
        
        if ($categories->isEmpty()) {
            $this->command->warn('News categories not found. Please run NewsCategorySeeder first.');
            return;
        }

        // Get first category as default
        $defaultCategory = $categories->first();
        
        $newsData = [
            [
                'title' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2025/2026',
                'content' => '<p>SMP Negeri 01 Namrole membuka pendaftaran peserta didik baru untuk tahun ajaran 2025/2026. Pendaftaran dibuka mulai tanggal 1 Januari 2025 hingga 31 Maret 2025.</p><p>Persyaratan pendaftaran:</p><ul><li>Lulusan SD/MI tahun 2025</li><li>Usia maksimal 15 tahun</li><li>Membawa fotokopi ijazah dan raport</li><li>Pas foto 3x4 sebanyak 2 lembar</li></ul><p>Informasi lebih lanjut dapat menghubungi panitia PPDB di sekolah.</p>',
                'category_id' => $defaultCategory->id,
                'author_id' => $admin->id,
                'is_featured' => true,
                'published_at' => now()->subDays(2),
                'views' => 156,
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler Semester Genap',
                'content' => '<p>Berbagai kegiatan ekstrakurikuler akan dimulai pada semester genap tahun ajaran 2024/2025. Kegiatan yang tersedia meliputi:</p><ul><li>Pramuka</li><li>Paskibra</li><li>Olahraga (Bola Voli, Sepak Bola, Basket)</li><li>Seni (Tari, Musik, Teater)</li><li>KIR (Karya Ilmiah Remaja)</li><li>English Club</li></ul><p>Pendaftaran ekstrakurikuler dibuka mulai tanggal 15 Januari 2025.</p>',
                'category_id' => $defaultCategory->id,
                'author_id' => $admin->id,
                'is_featured' => false,
                'published_at' => now()->subDays(5),
                'views' => 89,
            ],
            [
                'title' => 'Prestasi Siswa di Olimpiade Matematika Tingkat Kabupaten',
                'content' => '<p>Siswa SMP Negeri 01 Namrole berhasil meraih prestasi membanggakan dalam Olimpiade Matematika tingkat kabupaten yang diselenggarakan pada tanggal 20 Desember 2024.</p><p>Prestasi yang diraih:</p><ul><li>Juara 1: Ahmad Fauzi (Kelas IX-A)</li><li>Juara 2: Siti Nurhaliza (Kelas VIII-B)</li><li>Juara 3: Muhammad Rizki (Kelas IX-C)</li></ul><p>Kepala sekolah mengucapkan selamat kepada para siswa yang berprestasi dan berharap dapat mempertahankan prestasi ini di tingkat yang lebih tinggi.</p>',
                'category_id' => $defaultCategory->id,
                'author_id' => $admin->id,
                'is_featured' => true,
                'published_at' => now()->subDays(7),
                'views' => 234,
            ],
            [
                'title' => 'Pembagian Raport Semester Ganjil',
                'content' => '<p>Pembagian raport semester ganjil tahun ajaran 2024/2025 akan dilaksanakan pada:</p><p><strong>Hari/Tanggal:</strong> Sabtu, 18 Januari 2025<br><strong>Waktu:</strong> 08.00 - 12.00 WIB<br><strong>Tempat:</strong> Ruang Kelas Masing-masing</p><p>Orang tua/wali siswa diharapkan hadir untuk mengambil raport dan berdiskusi dengan wali kelas mengenai perkembangan belajar siswa.</p>',
                'category_id' => $defaultCategory->id,
                'author_id' => $admin->id,
                'is_featured' => false,
                'published_at' => now()->subDays(10),
                'views' => 67,
            ],
            [
                'title' => 'Workshop Pembelajaran Berbasis Teknologi',
                'content' => '<p>SMP Negeri 01 Namrole mengadakan workshop pembelajaran berbasis teknologi untuk seluruh guru pada tanggal 25-26 Januari 2025.</p><p>Workshop ini bertujuan untuk meningkatkan kompetensi guru dalam menggunakan teknologi pembelajaran modern, termasuk:</p><ul><li>Penggunaan platform pembelajaran online</li><li>Pembuatan konten pembelajaran digital</li><li>Manajemen kelas virtual</li><li>Penilaian berbasis teknologi</li></ul><p>Workshop diharapkan dapat meningkatkan kualitas pembelajaran di sekolah.</p>',
                'category_id' => $defaultCategory->id,
                'author_id' => $admin->id,
                'is_featured' => false,
                'published_at' => now()->subDays(12),
                'views' => 45,
            ],
            [
                'title' => 'Renovasi Laboratorium Komputer',
                'content' => '<p>Laboratorium komputer SMP Negeri 01 Namrole sedang dalam proses renovasi untuk meningkatkan fasilitas pembelajaran teknologi informasi.</p><p>Renovasi meliputi:</p><ul><li>Pemasangan komputer terbaru</li><li>Peningkatan jaringan internet</li><li>Pemasangan proyektor dan layar</li><li>Pembaruan software pembelajaran</li></ul><p>Laboratorium diharapkan dapat digunakan kembali pada awal semester genap tahun ajaran 2024/2025.</p>',
                'category_id' => $defaultCategory->id,
                'author_id' => $admin->id,
                'is_featured' => false,
                'published_at' => now()->subDays(15),
                'views' => 78,
            ],
        ];

        foreach ($newsData as $data) {
            $news = News::create([
                'title' => $data['title'],
                'slug' => \Illuminate\Support\Str::slug($data['title']),
                'content' => $data['content'],
                'category_id' => $data['category_id'],
                'author_id' => $data['author_id'],
                'is_featured' => $data['is_featured'],
                'published_at' => $data['published_at'],
                'views' => $data['views'],
            ]);
        }

        $this->command->info('News seeded successfully!');
    }
}
