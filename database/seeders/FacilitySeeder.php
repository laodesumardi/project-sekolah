<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;
use App\Models\User;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user as creator
        $user = User::first();
        
        if (!$user) {
            $this->command->info('No users found. Please create a user first.');
            return;
        }

        $facilities = [
            [
                'name' => 'Laboratorium Komputer',
                'slug' => 'laboratorium-komputer',
                'category' => 'laboratorium',
                'description' => 'Laboratorium komputer yang dilengkapi dengan 30 unit komputer modern untuk mendukung pembelajaran teknologi informasi dan komunikasi. Ruangan ini memiliki AC, proyektor, dan jaringan internet yang stabil.',
                'capacity' => 30,
                'location' => 'Gedung A',
                'floor' => 'Lantai 2',
                'facilities_spec' => 'AC, Proyektor, Sound System, WiFi, 30 Unit Komputer',
                'sort_order' => 1,
                'is_available' => true,
                'created_by' => $user->id,
                'image' => 'facilities/lab-komputer.jpg',
                'thumbnail' => 'facilities/thumbnails/lab-komputer.jpg'
            ],
            [
                'name' => 'Laboratorium IPA',
                'slug' => 'laboratorium-ipa',
                'category' => 'laboratorium',
                'description' => 'Laboratorium IPA yang dilengkapi dengan peralatan praktikum untuk mata pelajaran Fisika, Kimia, dan Biologi. Ruangan ini memiliki meja praktikum, lemari alat, dan fasilitas keamanan yang memadai.',
                'capacity' => 24,
                'location' => 'Gedung B',
                'floor' => 'Lantai 1',
                'facilities_spec' => 'AC, Meja Praktikum, Lemari Alat, Wastafel, Kaca Mata Pelindung',
                'sort_order' => 2,
                'is_available' => true,
                'created_by' => $user->id,
                'image' => 'facilities/lab-ipa.jpg',
                'thumbnail' => 'facilities/thumbnails/lab-ipa.jpg'
            ],
            [
                'name' => 'Ruang Kelas 7A',
                'slug' => 'ruang-kelas-7a',
                'category' => 'ruang_kelas',
                'description' => 'Ruang kelas untuk siswa kelas 7A dengan kapasitas 32 siswa. Dilengkapi dengan papan tulis, meja dan kursi yang nyaman, serta ventilasi yang baik.',
                'capacity' => 32,
                'location' => 'Gedung A',
                'floor' => 'Lantai 1',
                'facilities_spec' => 'Papan Tulis, Meja Kursi, Ventilasi, Lampu LED',
                'sort_order' => 3,
                'is_available' => true,
                'created_by' => $user->id,
                'image' => 'facilities/kelas-7a.jpg',
                'thumbnail' => 'facilities/thumbnails/kelas-7a.jpg'
            ],
            [
                'name' => 'Perpustakaan Sekolah',
                'slug' => 'perpustakaan-sekolah',
                'category' => 'perpustakaan',
                'description' => 'Perpustakaan sekolah yang dilengkapi dengan koleksi buku yang lengkap, ruang baca yang nyaman, dan sistem komputerisasi perpustakaan. Terdapat juga ruang diskusi kelompok.',
                'capacity' => 50,
                'location' => 'Gedung C',
                'floor' => 'Lantai 1',
                'facilities_spec' => 'AC, Rak Buku, Meja Baca, Komputer, WiFi, Ruang Diskusi',
                'sort_order' => 4,
                'is_available' => true,
                'created_by' => $user->id,
                'image' => 'facilities/perpustakaan.jpg',
                'thumbnail' => 'facilities/thumbnails/perpustakaan.jpg'
            ],
            [
                'name' => 'Lapangan Basket',
                'slug' => 'lapangan-basket',
                'category' => 'olahraga',
                'description' => 'Lapangan basket outdoor dengan standar internasional. Dilengkapi dengan ring basket, garis lapangan yang jelas, dan area duduk untuk penonton.',
                'capacity' => 100,
                'location' => 'Area Olahraga',
                'floor' => 'Lantai Dasar',
                'facilities_spec' => 'Ring Basket, Garis Lapangan, Area Duduk, Pencahayaan Malam',
                'sort_order' => 5,
                'is_available' => true,
                'created_by' => $user->id,
                'image' => 'facilities/lapangan-basket.jpg',
                'thumbnail' => 'facilities/thumbnails/lapangan-basket.jpg'
            ],
            [
                'name' => 'Mushola Al-Ikhlas',
                'slug' => 'mushola-al-ikhlas',
                'category' => 'mushola',
                'description' => 'Mushola sekolah yang dapat menampung jamaah untuk shalat berjamaah. Dilengkapi dengan sound system, karpet shalat, dan tempat wudhu yang bersih.',
                'capacity' => 60,
                'location' => 'Gedung A',
                'floor' => 'Lantai 1',
                'facilities_spec' => 'Sound System, Karpet Shalat, Tempat Wudhu, AC',
                'sort_order' => 6,
                'is_available' => true,
                'created_by' => $user->id,
                'image' => 'facilities/mushola.jpg',
                'thumbnail' => 'facilities/thumbnails/mushola.jpg'
            ],
            [
                'name' => 'Kantin Sekolah',
                'slug' => 'kantin-sekolah',
                'category' => 'kantin',
                'description' => 'Kantin sekolah yang menyediakan berbagai makanan dan minuman sehat untuk siswa dan guru. Dilengkapi dengan meja dan kursi yang memadai.',
                'capacity' => 40,
                'location' => 'Gedung B',
                'floor' => 'Lantai Dasar',
                'facilities_spec' => 'Meja Kursi, Kulkas, Kompor, Tempat Cuci Piring',
                'sort_order' => 7,
                'is_available' => true,
                'created_by' => $user->id,
                'image' => 'facilities/kantin.jpg',
                'thumbnail' => 'facilities/thumbnails/kantin.jpg'
            ]
        ];

        foreach ($facilities as $facilityData) {
            Facility::create($facilityData);
        }

        $this->command->info('Facility seeder completed successfully!');
    }
}