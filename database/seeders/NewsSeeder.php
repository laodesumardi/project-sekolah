<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create news categories
        $categories = [
            ['name' => 'Kegiatan Sekolah', 'slug' => 'kegiatan-sekolah', 'description' => 'Berita tentang kegiatan sekolah'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'description' => 'Berita tentang prestasi siswa dan sekolah'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'description' => 'Pengumuman penting dari sekolah'],
            ['name' => 'Ekstrakurikuler', 'slug' => 'ekstrakurikuler', 'description' => 'Berita tentang kegiatan ekstrakurikuler'],
        ];

        foreach ($categories as $categoryData) {
            NewsCategory::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Get admin user
        $admin = User::where('email', 'admin@sekolah.com')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin Sekolah',
                'email' => 'admin@sekolah.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Get categories
        $kegiatanCategory = NewsCategory::where('slug', 'kegiatan-sekolah')->first();
        $prestasiCategory = NewsCategory::where('slug', 'prestasi')->first();
        $pengumumanCategory = NewsCategory::where('slug', 'pengumuman')->first();
        $ekstrakurikulerCategory = NewsCategory::where('slug', 'ekstrakurikuler')->first();

        // Create sample news
        $newsData = [
            [
                'title' => 'Kegiatan Ekstrakurikuler Semester Genap',
                'slug' => 'kegiatan-ekstrakurikuler-semester-genap',
                'content' => '<p>Kegiatan ekstrakurikuler semester genap telah dimulai dengan berbagai program menarik untuk siswa SMP Negeri 01 Namrole. Program ini bertujuan untuk mengembangkan bakat dan minat siswa di luar jam pelajaran formal.</p>

                <h3>Program Ekstrakurikuler yang Tersedia:</h3>
                <ul>
                    <li><strong>Olahraga:</strong> Sepak bola, Voli, Basket, Badminton</li>
                    <li><strong>Seni:</strong> Tari tradisional, Musik, Teater</li>
                    <li><strong>Akademik:</strong> Olimpiade Matematika, Sains, Bahasa Inggris</li>
                    <li><strong>Keterampilan:</strong> Komputer, Kerajinan, Pertanian</li>
                </ul>

                <p>Kegiatan ekstrakurikuler dilaksanakan setiap hari Selasa dan Kamis pukul 15.00-17.00 WIB. Siswa dapat memilih maksimal 2 ekstrakurikuler sesuai dengan minat dan bakat mereka.</p>

                <h3>Pendaftaran:</h3>
                <p>Pendaftaran dibuka mulai tanggal 15 Januari 2025 dan akan ditutup pada tanggal 25 Januari 2025. Siswa dapat mendaftar melalui wali kelas masing-masing.</p>

                <p>Dengan mengikuti ekstrakurikuler, siswa diharapkan dapat mengembangkan potensi diri, meningkatkan keterampilan sosial, dan menciptakan prestasi yang membanggakan.</p>',
                'excerpt' => 'Kegiatan ekstrakurikuler semester genap telah dimulai dengan berbagai program menarik untuk mengembangkan bakat dan minat siswa.',
                'category_id' => $ekstrakurikulerCategory->id,
                'author_id' => $admin->id,
                'is_featured' => true,
                'published_at' => now()->subDays(2),
                'meta_title' => 'Kegiatan Ekstrakurikuler Semester Genap - SMP Negeri 01 Namrole',
                'meta_description' => 'Program ekstrakurikuler semester genap dengan berbagai kegiatan olahraga, seni, akademik, dan keterampilan untuk siswa.',
                'meta_keywords' => 'ekstrakurikuler, kegiatan sekolah, semester genap, olahraga, seni, akademik',
                'allow_comments' => true,
            ],
            [
                'title' => 'Prestasi Siswa di Olimpiade Matematika Tingkat Provinsi',
                'slug' => 'prestasi-siswa-olimpiade-matematika-provinsi',
                'content' => '<p>Kami bangga mengumumkan bahwa siswa SMP Negeri 01 Namrole berhasil meraih prestasi gemilang dalam Olimpiade Matematika Tingkat Provinsi Maluku yang diselenggarakan pada tanggal 10 Januari 2025.</p>

                <h3>Prestasi yang Diraih:</h3>
                <ul>
                    <li><strong>Juara 1:</strong> Ahmad Fauzi (Kelas 9A)</li>
                    <li><strong>Juara 2:</strong> Siti Nurhaliza (Kelas 8B)</li>
                    <li><strong>Juara 3:</strong> Muhammad Rizki (Kelas 9C)</li>
                </ul>

                <p>Prestasi ini merupakan bukti nyata dari dedikasi dan kerja keras siswa-siswi SMP Negeri 01 Namrole dalam bidang akademik. Kami mengucapkan selamat kepada para pemenang dan berharap prestasi ini dapat memotivasi siswa lainnya untuk terus berprestasi.</p>

                <p>Kepala Sekolah, Bapak Dr. H. Ahmad Suryadi, M.Pd., menyampaikan apresiasi yang tinggi kepada para siswa yang telah mengharumkan nama sekolah di tingkat provinsi.</p>',
                'excerpt' => 'Siswa SMP Negeri 01 Namrole berhasil meraih prestasi gemilang dalam Olimpiade Matematika Tingkat Provinsi Maluku.',
                'category_id' => $prestasiCategory->id,
                'author_id' => $admin->id,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
                'meta_title' => 'Prestasi Siswa Olimpiade Matematika Provinsi - SMP Negeri 01 Namrole',
                'meta_description' => 'Siswa SMP Negeri 01 Namrole meraih juara 1, 2, dan 3 dalam Olimpiade Matematika Tingkat Provinsi Maluku.',
                'meta_keywords' => 'prestasi, olimpiade matematika, provinsi, siswa, prestasi akademik',
                'allow_comments' => true,
            ],
            [
                'title' => 'Pengumuman Libur Semester Genap',
                'slug' => 'pengumuman-libur-semester-genap',
                'content' => '<p>Berdasarkan kalender akademik tahun pelajaran 2024/2025, kami mengumumkan jadwal libur semester genap sebagai berikut:</p>

                <h3>Jadwal Libur Semester Genap:</h3>
                <ul>
                    <li><strong>Libur Tengah Semester:</strong> 15-20 Maret 2025</li>
                    <li><strong>Libur Akhir Semester:</strong> 15-30 Juni 2025</li>
                    <li><strong>Libur Idul Fitri:</strong> 25-30 April 2025</li>
                </ul>

                <p>Selama masa libur, siswa diharapkan untuk:</p>
                <ul>
                    <li>Mengisi waktu dengan kegiatan yang positif</li>
                    <li>Menyelesaikan tugas-tugas yang diberikan guru</li>
                    <li>Mempersiapkan diri untuk semester berikutnya</li>
                </ul>

                <p>Informasi lebih lanjut dapat menghubungi wali kelas atau bagian akademik sekolah.</p>',
                'excerpt' => 'Pengumuman jadwal libur semester genap tahun pelajaran 2024/2025 untuk siswa SMP Negeri 01 Namrole.',
                'category_id' => $pengumumanCategory->id,
                'author_id' => $admin->id,
                'is_featured' => false,
                'published_at' => now()->subDays(1),
                'meta_title' => 'Pengumuman Libur Semester Genap - SMP Negeri 01 Namrole',
                'meta_description' => 'Jadwal libur semester genap tahun pelajaran 2024/2025 untuk siswa SMP Negeri 01 Namrole.',
                'meta_keywords' => 'libur semester, kalender akademik, pengumuman, jadwal libur',
                'allow_comments' => true,
            ],
            [
                'title' => 'Kegiatan Pramuka dan Kepramukaan',
                'slug' => 'kegiatan-pramuka-kepramukaan',
                'content' => '<p>Gerakan Pramuka SMP Negeri 01 Namrole mengadakan berbagai kegiatan kepramukaan yang bertujuan untuk membentuk karakter dan kepribadian siswa yang berakhlak mulia.</p>

                <h3>Kegiatan Pramuka yang Dilaksanakan:</h3>
                <ul>
                    <li><strong>Latihan Rutin:</strong> Setiap hari Sabtu pukul 07.00-10.00 WIB</li>
                    <li><strong>Kemah Akhir Pekan:</strong> Setiap bulan sekali</li>
                    <li><strong>Perkemahan Besar:</strong> Setiap semester</li>
                    <li><strong>Lomba Pramuka:</strong> Tingkat kecamatan dan kabupaten</li>
                </ul>

                <p>Kegiatan pramuka tidak hanya mengajarkan keterampilan kepramukaan, tetapi juga menanamkan nilai-nilai kepemimpinan, kedisiplinan, dan kerja sama tim.</p>

                <h3>Prestasi Pramuka:</h3>
                <p>Tim Pramuka SMP Negeri 01 Namrole telah meraih berbagai prestasi di tingkat kecamatan dan kabupaten, termasuk Juara 1 Lomba Pramuka Tingkat Kecamatan pada tahun 2024.</p>',
                'excerpt' => 'Kegiatan kepramukaan SMP Negeri 01 Namrole untuk membentuk karakter dan kepribadian siswa yang berakhlak mulia.',
                'category_id' => $kegiatanCategory->id,
                'author_id' => $admin->id,
                'is_featured' => false,
                'published_at' => now()->subDays(3),
                'meta_title' => 'Kegiatan Pramuka dan Kepramukaan - SMP Negeri 01 Namrole',
                'meta_description' => 'Kegiatan kepramukaan SMP Negeri 01 Namrole untuk membentuk karakter siswa yang berakhlak mulia.',
                'meta_keywords' => 'pramuka, kepramukaan, kegiatan sekolah, karakter, kepribadian',
                'allow_comments' => true,
            ],
        ];

        foreach ($newsData as $data) {
            News::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        $this->command->info('News seeded successfully!');
    }
}