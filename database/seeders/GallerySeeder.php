<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleryData = [
            [
                'title' => 'Kegiatan Upacara Bendera',
                'description' => 'Upacara bendera rutin setiap hari Senin di halaman sekolah',
                'image' => 'upacara-bendera.jpg',
                'category' => 'Kegiatan',
                'is_active' => true,
            ],
            [
                'title' => 'Laboratorium Komputer',
                'description' => 'Fasilitas laboratorium komputer yang modern dan lengkap',
                'image' => 'lab-komputer.jpg',
                'category' => 'Fasilitas',
                'is_active' => true,
            ],
            [
                'title' => 'Perpustakaan Sekolah',
                'description' => 'Perpustakaan dengan koleksi buku yang lengkap dan nyaman',
                'image' => 'perpustakaan.jpg',
                'category' => 'Fasilitas',
                'is_active' => true,
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler Pramuka',
                'description' => 'Kegiatan ekstrakurikuler pramuka yang rutin dilaksanakan',
                'image' => 'pramuka.jpg',
                'category' => 'Kegiatan',
                'is_active' => true,
            ],
            [
                'title' => 'Lapangan Olahraga',
                'description' => 'Lapangan olahraga yang luas untuk berbagai kegiatan',
                'image' => 'lapangan-olahraga.jpg',
                'category' => 'Fasilitas',
                'is_active' => true,
            ],
            [
                'title' => 'Kegiatan Pentas Seni',
                'description' => 'Pentas seni tahunan yang menampilkan bakat siswa',
                'image' => 'pentas-seni.jpg',
                'category' => 'Kegiatan',
                'is_active' => true,
            ],
        ];

        foreach ($galleryData as $data) {
            Gallery::create($data);
        }

        $this->command->info('Gallery seeded successfully!');
    }
}

