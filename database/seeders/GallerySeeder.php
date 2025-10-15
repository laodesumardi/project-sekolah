<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@sekolah.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);
        }

        // Sample galleries data
        $galleries = [
            [
                'title' => 'Lomba 17 Agustus 2024',
                'description' => 'Dokumentasi kegiatan lomba dalam rangka memperingati Hari Kemerdekaan Republik Indonesia ke-79. Berbagai lomba menarik diikuti oleh siswa-siswi dengan semangat kebangsaan yang tinggi.',
                'category' => 'kegiatan',
                'date' => '2024-08-17',
                'location' => 'Lapangan Sekolah',
                'photographer' => 'Tim Dokumentasi Sekolah',
                'is_published' => true,
                'is_featured' => true,
                'view_count' => 156,
                'total_photos' => 24
            ],
            [
                'title' => 'Prestasi Olimpiade Matematika',
                'description' => 'Koleksi foto siswa-siswi yang berhasil meraih prestasi di berbagai olimpiade matematika tingkat kabupaten dan provinsi.',
                'category' => 'prestasi',
                'date' => '2024-09-15',
                'location' => 'Aula Sekolah',
                'photographer' => 'Guru Matematika',
                'is_published' => true,
                'is_featured' => true,
                'view_count' => 89,
                'total_photos' => 12
            ],
            [
                'title' => 'Fasilitas Laboratorium Komputer',
                'description' => 'Galeri fasilitas laboratorium komputer yang dilengkapi dengan peralatan modern untuk mendukung pembelajaran teknologi informasi.',
                'category' => 'fasilitas',
                'date' => null,
                'location' => 'Laboratorium Komputer',
                'photographer' => 'Tim IT Sekolah',
                'is_published' => true,
                'is_featured' => false,
                'view_count' => 67,
                'total_photos' => 8
            ],
            [
                'title' => 'Event Pentas Seni 2024',
                'description' => 'Pertunjukan seni dan budaya yang menampilkan bakat siswa-siswi dalam berbagai bidang seni seperti tari, musik, dan drama.',
                'category' => 'event',
                'date' => '2024-10-20',
                'location' => 'Aula Serbaguna',
                'photographer' => 'Tim Dokumentasi',
                'is_published' => true,
                'is_featured' => false,
                'view_count' => 134,
                'total_photos' => 18
            ],
            [
                'title' => 'Turnamen Futsal Antar Kelas',
                'description' => 'Kompetisi futsal yang diikuti oleh perwakilan dari setiap kelas dengan semangat sportivitas dan persahabatan.',
                'category' => 'olahraga',
                'date' => '2024-11-05',
                'location' => 'Lapangan Futsal',
                'photographer' => 'Guru Olahraga',
                'is_published' => true,
                'is_featured' => false,
                'view_count' => 78,
                'total_photos' => 15
            ],
            [
                'title' => 'Pameran Karya Seni Siswa',
                'description' => 'Pameran karya seni rupa dan kerajinan tangan hasil kreativitas siswa-siswi yang menampilkan bakat seni yang luar biasa.',
                'category' => 'seni',
                'date' => '2024-12-01',
                'location' => 'Galeri Seni',
                'photographer' => 'Guru Seni',
                'is_published' => true,
                'is_featured' => false,
                'view_count' => 92,
                'total_photos' => 20
            ]
        ];

        foreach ($galleries as $galleryData) {
            $gallery = Gallery::create([
                'title' => $galleryData['title'],
                'slug' => Str::slug($galleryData['title']),
                'description' => $galleryData['description'],
                'category' => $galleryData['category'],
                'date' => $galleryData['date'],
                'location' => $galleryData['location'],
                'photographer' => $galleryData['photographer'],
                'is_published' => $galleryData['is_published'],
                'is_featured' => $galleryData['is_featured'],
                'view_count' => $galleryData['view_count'],
                'total_photos' => $galleryData['total_photos'],
                'created_by' => $admin->id
            ]);

            // Create sample images for each gallery
            $this->createSampleImages($gallery, $galleryData['total_photos']);
        }
    }

    private function createSampleImages($gallery, $totalPhotos)
    {
        for ($i = 1; $i <= $totalPhotos; $i++) {
            $filename = 'sample_' . $gallery->id . '_' . $i . '.jpg';
            
            // Create sample image file
            $this->createSampleImageFile($filename);
            
            GalleryImage::create([
                'gallery_id' => $gallery->id,
                'image' => $filename,
                'thumbnail' => $filename,
                'medium' => $filename,
                'title' => 'Foto ' . $i . ' - ' . $gallery->title,
                'caption' => 'Dokumentasi ' . $gallery->title . ' - Foto ke ' . $i,
                'alt_text' => $gallery->title . ' - Foto ' . $i,
                'file_size' => rand(500000, 2000000), // 500KB - 2MB
                'mime_type' => 'image/jpeg',
                'width' => rand(800, 1920),
                'height' => rand(600, 1080),
                'sort_order' => $i - 1,
                'is_cover' => $i === 1, // First image as cover
                'view_count' => rand(0, 50)
            ]);
        }
    }

    private function createSampleImageFile($filename)
    {
        // Create a simple sample image (SVG converted to base64)
        $svgContent = '<?xml version="1.0" encoding="UTF-8"?>
        <svg width="800" height="600" viewBox="0 0 800 600" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="800" height="600" fill="#F3F4F6"/>
            <rect x="100" y="100" width="600" height="400" fill="#D9D9DE"/>
            <rect x="150" y="150" width="500" height="300" fill="#000000"/>
            <circle cx="200" cy="300" r="20" fill="#FFFFFF"/>
            <text x="400" y="320" text-anchor="middle" fill="#FFFFFF" font-family="Arial" font-size="24">Sample Image</text>
        </svg>';

        // Convert SVG to base64
        $base64 = base64_encode($svgContent);
        
        // Create image file
        $imagePath = storage_path('app/public/gallery/' . $filename);
        file_put_contents($imagePath, base64_decode($base64));
        
        // Create thumbnail
        $thumbnailPath = storage_path('app/public/gallery/thumbnails/' . $filename);
        file_put_contents($thumbnailPath, base64_decode($base64));
        
        // Create medium size
        $mediumPath = storage_path('app/public/gallery/medium/' . $filename);
        file_put_contents($mediumPath, base64_decode($base64));
    }
}