<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all galleries
        $galleries = Gallery::all();
        
        if ($galleries->count() == 0) {
            $this->command->warn('No galleries found. Please run GallerySeeder first.');
            return;
        }

        // Sample image data
        $sampleImages = [
            [
                'title' => 'Kegiatan Ekstrakurikuler',
                'caption' => 'Siswa sedang mengikuti kegiatan ekstrakurikuler basket',
                'alt_text' => 'Kegiatan ekstrakurikuler basket',
            ],
            [
                'title' => 'Upacara Bendera',
                'caption' => 'Upacara bendera setiap hari Senin',
                'alt_text' => 'Upacara bendera hari Senin',
            ],
            [
                'title' => 'Kelas Belajar',
                'caption' => 'Siswa sedang belajar di kelas',
                'alt_text' => 'Kelas belajar siswa',
            ],
            [
                'title' => 'Perpustakaan',
                'caption' => 'Siswa membaca di perpustakaan sekolah',
                'alt_text' => 'Perpustakaan sekolah',
            ],
            [
                'title' => 'Laboratorium IPA',
                'caption' => 'Praktikum di laboratorium IPA',
                'alt_text' => 'Laboratorium IPA',
            ],
        ];

        foreach ($galleries as $gallery) {
            // Add 3-5 images to each gallery
            $imageCount = rand(3, 5);
            
            for ($i = 0; $i < $imageCount; $i++) {
                $sampleImage = $sampleImages[array_rand($sampleImages)];
                $filename = 'gallery_' . $gallery->id . '_' . ($i + 1) . '.jpg';
                
                // Create placeholder image data
                $imageData = [
                    'gallery_id' => $gallery->id,
                    'image' => 'gallery/' . $filename,
                    'thumbnail' => 'gallery/thumbnails/' . $filename,
                    'medium' => 'gallery/medium/' . $filename,
                    'title' => $sampleImage['title'] . ' ' . ($i + 1),
                    'caption' => $sampleImage['caption'],
                    'alt_text' => $sampleImage['alt_text'],
                    'file_size' => rand(500000, 2000000), // 500KB to 2MB
                    'mime_type' => 'image/jpeg',
                    'width' => rand(800, 1200),
                    'height' => rand(600, 900),
                    'sort_order' => $i + 1,
                    'is_cover' => $i === 0, // First image is cover
                    'view_count' => rand(0, 100)
                ];
                
                GalleryImage::create($imageData);
            }
            
            // Update gallery total photos count
            $gallery->update(['total_photos' => $gallery->images()->count()]);
            
            // Set cover image
            $coverImage = $gallery->images()->where('is_cover', true)->first();
            if ($coverImage) {
                $gallery->update(['cover_image' => $coverImage->image]);
            }
        }

        $this->command->info('Gallery images have been seeded successfully.');
    }
}


