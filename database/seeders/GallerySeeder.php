<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\User;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get admin user for created_by
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = User::first();
        }

        $galleries = [
            [
                'title' => 'Upacara Bendera Hari Senin',
                'description' => 'Momen upacara bendera yang dilaksanakan setiap hari Senin dengan penuh khidmat dan disiplin.',
                'category' => 'kegiatan',
                'date' => '2024-10-14',
                'location' => 'Lapangan Upacara SMP Negeri 01 Namrole',
                'photographer' => 'Tim Dokumentasi Sekolah',
                'is_published' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'view_count' => 45,
                'total_photos' => 8,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'title' => 'Prestasi Olimpiade Matematika',
                'description' => 'Kegiatan persiapan dan pencapaian prestasi siswa dalam olimpiade matematika tingkat kabupaten.',
                'category' => 'prestasi',
                'date' => '2024-10-10',
                'location' => 'SMP Negeri 01 Namrole',
                'photographer' => 'Guru Matematika',
                'is_published' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'view_count' => 67,
                'total_photos' => 12,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'title' => 'Fasilitas Laboratorium Komputer',
                'description' => 'Dokumentasi fasilitas laboratorium komputer yang modern dan lengkap untuk mendukung pembelajaran IT.',
                'category' => 'fasilitas',
                'date' => '2024-10-08',
                'location' => 'Laboratorium Komputer SMP Negeri 01 Namrole',
                'photographer' => 'Tim IT Sekolah',
                'is_published' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'view_count' => 23,
                'total_photos' => 6,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler Pramuka',
                'description' => 'Aktivitas ekstrakurikuler pramuka yang membentuk karakter dan kepemimpinan siswa.',
                'category' => 'kegiatan',
                'date' => '2024-10-05',
                'location' => 'Lapangan Sekolah',
                'photographer' => 'Pembina Pramuka',
                'is_published' => true,
                'is_featured' => false,
                'sort_order' => 4,
                'view_count' => 34,
                'total_photos' => 15,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'title' => 'Prestasi Lomba Seni Tari',
                'description' => 'Penampilan dan prestasi siswa dalam lomba seni tari tingkat kabupaten.',
                'category' => 'prestasi',
                'date' => '2024-10-03',
                'location' => 'Aula Kabupaten',
                'photographer' => 'Guru Seni',
                'is_published' => true,
                'is_featured' => true,
                'sort_order' => 5,
                'view_count' => 89,
                'total_photos' => 20,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'title' => 'Perpustakaan Digital',
                'description' => 'Fasilitas perpustakaan digital yang modern dengan koleksi buku dan akses digital.',
                'category' => 'fasilitas',
                'date' => '2024-10-01',
                'location' => 'Perpustakaan SMP Negeri 01 Namrole',
                'photographer' => 'Pustakawan',
                'is_published' => true,
                'is_featured' => false,
                'sort_order' => 6,
                'view_count' => 28,
                'total_photos' => 10,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'title' => 'Kegiatan Olahraga Futsal',
                'description' => 'Latihan dan pertandingan futsal siswa untuk mengembangkan bakat olahraga.',
                'category' => 'olahraga',
                'date' => '2024-09-28',
                'location' => 'Lapangan Futsal Sekolah',
                'photographer' => 'Guru Olahraga',
                'is_published' => true,
                'is_featured' => false,
                'sort_order' => 7,
                'view_count' => 41,
                'total_photos' => 18,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'title' => 'Prestasi Akademik Semester Ganjil',
                'description' => 'Penghargaan dan apresiasi untuk siswa berprestasi akademik semester ganjil.',
                'category' => 'akademik',
                'date' => '2024-09-25',
                'location' => 'Aula Sekolah',
                'photographer' => 'Tim Dokumentasi',
                'is_published' => true,
                'is_featured' => true,
                'sort_order' => 8,
                'view_count' => 56,
                'total_photos' => 14,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'title' => 'Kegiatan Seni Rupa',
                'description' => 'Aktivitas pembelajaran dan karya seni rupa siswa yang kreatif dan inovatif.',
                'category' => 'seni',
                'date' => '2024-09-22',
                'location' => 'Ruang Seni SMP Negeri 01 Namrole',
                'photographer' => 'Guru Seni Rupa',
                'is_published' => true,
                'is_featured' => false,
                'sort_order' => 9,
                'view_count' => 32,
                'total_photos' => 16,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ],
            [
                'title' => 'Fasilitas Laboratorium IPA',
                'description' => 'Dokumentasi fasilitas laboratorium IPA yang lengkap untuk pembelajaran sains.',
                'category' => 'fasilitas',
                'date' => '2024-09-20',
                'location' => 'Laboratorium IPA SMP Negeri 01 Namrole',
                'photographer' => 'Guru IPA',
                'is_published' => true,
                'is_featured' => false,
                'sort_order' => 10,
                'view_count' => 19,
                'total_photos' => 8,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]
        ];

        foreach ($galleries as $galleryData) {
            $gallery = Gallery::create($galleryData);
            
            // Create sample images for each gallery
            $this->createGalleryImages($gallery, $galleryData['total_photos']);
        }
    }

    /**
     * Create sample images for a gallery
     */
    private function createGalleryImages($gallery, $totalPhotos)
    {
        $sampleImages = [
            'upacara-bendera-1.jpg',
            'upacara-bendera-2.jpg',
            'upacara-bendera-3.jpg',
            'olimpiade-math-1.jpg',
            'olimpiade-math-2.jpg',
            'olimpiade-math-3.jpg',
            'lab-komputer-1.jpg',
            'lab-komputer-2.jpg',
            'pramuka-1.jpg',
            'pramuka-2.jpg',
            'seni-tari-1.jpg',
            'seni-tari-2.jpg',
            'perpustakaan-1.jpg',
            'perpustakaan-2.jpg',
            'futsal-1.jpg',
            'futsal-2.jpg',
            'prestasi-akademik-1.jpg',
            'prestasi-akademik-2.jpg',
            'seni-rupa-1.jpg',
            'seni-rupa-2.jpg',
            'lab-ipa-1.jpg',
            'lab-ipa-2.jpg'
        ];

        for ($i = 0; $i < $totalPhotos; $i++) {
            $imageName = $sampleImages[array_rand($sampleImages)];
            
            GalleryImage::create([
                'gallery_id' => $gallery->id,
                'image' => $imageName,
                'thumbnail' => 'thumb_' . $imageName,
                'medium' => 'medium_' . $imageName,
                'title' => $gallery->title . ' - Foto ' . ($i + 1),
                'caption' => 'Dokumentasi ' . $gallery->title . ' yang dilaksanakan pada ' . $gallery->formatted_date,
                'alt_text' => $gallery->title . ' - Foto ' . ($i + 1),
                'file_size' => rand(500000, 2000000), // 500KB - 2MB
                'mime_type' => 'image/jpeg',
                'width' => rand(800, 1920),
                'height' => rand(600, 1080),
                'sort_order' => $i + 1,
                'is_cover' => $i === 0, // First image is cover
                'view_count' => rand(5, 50)
            ]);
        }
    }
}