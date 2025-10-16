<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create news categories if they don't exist
        $categories = [
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'description' => 'Berita tentang pendidikan'],
            ['name' => 'Kegiatan Sekolah', 'slug' => 'kegiatan-sekolah', 'description' => 'Berita tentang kegiatan sekolah'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'description' => 'Berita tentang prestasi siswa'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'description' => 'Pengumuman resmi sekolah'],
        ];

        foreach ($categories as $category) {
            NewsCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }

        // Create tags if they don't exist
        $tags = [
            ['name' => 'Siswa', 'slug' => 'siswa'],
            ['name' => 'Guru', 'slug' => 'guru'],
            ['name' => 'Prestasi', 'slug' => 'prestasi'],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }

        // Get admin user
        $admin = User::where('email', 'admin@smpn01namrole.sch.id')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]);
        }

        // Create sample news items
        $newsItems = [
            [
                'title' => 'Pembukaan Tahun Ajaran Baru 2025-2026',
                'content' => '<p>Kami dengan bangga mengumumkan pembukaan tahun ajaran baru 2025/2026 di SMP Negeri 01 Namrole. Tahun ajaran ini akan dimulai pada tanggal 15 Juli 2025 dengan berbagai program unggulan yang telah disiapkan untuk memberikan pendidikan terbaik bagi seluruh siswa.</p><p>Program-program unggulan yang akan dilaksanakan meliputi:</p><ul><li>Program pengembangan karakter siswa</li><li>Kegiatan ekstrakurikuler yang beragam</li><li>Program bimbingan belajar intensif</li><li>Kegiatan keagamaan dan spiritual</li></ul><p>Kami berharap seluruh siswa dapat memanfaatkan kesempatan ini dengan sebaik-baiknya untuk meraih prestasi yang gemilang.</p>',
                'excerpt' => 'Pembukaan tahun ajaran baru 2025/2026 dengan berbagai program unggulan untuk memberikan pendidikan terbaik bagi seluruh siswa.',
                'category_id' => NewsCategory::where('slug', 'pengumuman')->first()->id,
                'author_id' => $admin->id,
                'is_featured' => true,
                'published_at' => now(),
                'meta_title' => 'Pembukaan Tahun Ajaran Baru 2025/2026 - SMP Negeri 01 Namrole',
                'meta_description' => 'Pengumuman pembukaan tahun ajaran baru 2025/2026 di SMP Negeri 01 Namrole dengan program unggulan.',
                'allow_comments' => true,
            ],
            [
                'title' => 'Siswa SMP Negeri 01 Namrole Raih Juara 1 Olimpiade Matematika',
                'content' => '<p>Kami bangga mengumumkan bahwa salah satu siswa terbaik kami, <strong>Andi Pratama</strong> dari kelas IX-A, berhasil meraih juara 1 dalam Olimpiade Matematika tingkat kabupaten yang diselenggarakan pada tanggal 10 Oktober 2025.</p><p>Prestasi ini merupakan hasil dari dedikasi dan kerja keras yang luar biasa dari siswa tersebut, serta dukungan penuh dari guru-guru matematika yang telah memberikan bimbingan intensif.</p><p>Kepala Sekolah, Bapak Dr. Budi Santoso, M.Pd., menyampaikan rasa bangga dan apresiasi yang tinggi atas prestasi yang diraih oleh Andi Pratama. "Ini adalah bukti bahwa dengan kerja keras dan dukungan yang tepat, setiap siswa dapat meraih prestasi yang gemilang," ujarnya.</p>',
                'excerpt' => 'Siswa SMP Negeri 01 Namrole berhasil meraih juara 1 Olimpiade Matematika tingkat kabupaten.',
                'category_id' => NewsCategory::where('slug', 'prestasi')->first()->id,
                'author_id' => $admin->id,
                'is_featured' => true,
                'published_at' => now(),
                'meta_title' => 'Siswa SMP Negeri 01 Namrole Juara 1 Olimpiade Matematika',
                'meta_description' => 'Prestasi gemilang siswa SMP Negeri 01 Namrole dalam Olimpiade Matematika tingkat kabupaten.',
                'allow_comments' => true,
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler Semester Ganjil 2025',
                'content' => '<p>Kegiatan ekstrakurikuler semester ganjil tahun ajaran 2025/2026 telah dimulai dengan antusiasme yang tinggi dari seluruh siswa. Berbagai jenis ekstrakurikuler tersedia untuk mengembangkan bakat dan minat siswa di luar jam pelajaran.</p><p>Jenis-jenis ekstrakurikuler yang tersedia:</p><ul><li><strong>Olahraga:</strong> Sepak Bola, Basket, Voli, Badminton</li><li><strong>Seni:</strong> Tari, Musik, Teater, Lukis</li><li><strong>Akademik:</strong> Matematika, IPA, Bahasa Inggris</li><li><strong>Keagamaan:</strong> Tahfidz, Qiro\'ah, Pramuka</li></ul><p>Kegiatan ekstrakurikuler dilaksanakan setiap hari Selasa dan Kamis pukul 14.00 - 16.00 WIT. Siswa dapat memilih maksimal 2 jenis ekstrakurikuler sesuai dengan minat dan bakat masing-masing.</p>',
                'excerpt' => 'Kegiatan ekstrakurikuler semester ganjil telah dimulai dengan berbagai pilihan untuk mengembangkan bakat siswa.',
                'category_id' => NewsCategory::where('slug', 'kegiatan-sekolah')->first()->id,
                'author_id' => $admin->id,
                'is_featured' => false,
                'published_at' => now(),
                'meta_title' => 'Kegiatan Ekstrakurikuler Semester Ganjil 2025',
                'meta_description' => 'Informasi lengkap tentang kegiatan ekstrakurikuler semester ganjil di SMP Negeri 01 Namrole.',
                'allow_comments' => true,
            ],
            [
                'title' => 'Workshop Guru: Peningkatan Kompetensi Pedagogik',
                'content' => '<p>Dalam rangka meningkatkan kualitas pembelajaran, SMP Negeri 01 Namrole menyelenggarakan workshop guru dengan tema "Peningkatan Kompetensi Pedagogik dalam Era Digital" pada tanggal 20-22 Oktober 2025.</p><p>Workshop ini diikuti oleh seluruh guru SMP Negeri 01 Namrole dan menghadirkan narasumber dari Universitas Pendidikan Indonesia (UPI) Bandung. Materi yang disampaikan meliputi:</p><ul><li>Strategi pembelajaran berbasis teknologi</li><li>Pengembangan media pembelajaran digital</li><li>Penilaian autentik dalam pembelajaran</li><li>Pengelolaan kelas yang efektif</li></ul><p>Kepala Sekolah berharap workshop ini dapat meningkatkan kualitas pembelajaran dan memberikan dampak positif bagi perkembangan siswa.</p>',
                'excerpt' => 'Workshop guru untuk peningkatan kompetensi pedagogik dalam era digital diikuti seluruh guru SMP Negeri 01 Namrole.',
                'category_id' => NewsCategory::where('slug', 'pendidikan')->first()->id,
                'author_id' => $admin->id,
                'is_featured' => false,
                'published_at' => now(),
                'meta_title' => 'Workshop Guru: Peningkatan Kompetensi Pedagogik',
                'meta_description' => 'Workshop guru SMP Negeri 01 Namrole untuk meningkatkan kompetensi pedagogik dalam era digital.',
                'allow_comments' => false,
            ],
        ];

        foreach ($newsItems as $newsData) {
            $news = News::create($newsData);
            
            // Attach tags
            $news->tags()->attach(Tag::whereIn('slug', ['siswa', 'guru', 'prestasi', 'kegiatan'])->pluck('id'));
        }

        $this->command->info('News items have been seeded successfully.');
    }
}