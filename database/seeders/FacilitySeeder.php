<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Laboratorium Komputer',
                'description' => 'Laboratorium komputer dengan 30 unit komputer untuk pembelajaran TIK',
                'image' => 'lab-komputer.jpg',
                'capacity' => 30,
                'is_available' => true,
            ],
            [
                'name' => 'Laboratorium IPA',
                'description' => 'Laboratorium IPA lengkap dengan peralatan praktikum',
                'image' => 'lab-ipa.jpg',
                'capacity' => 25,
                'is_available' => true,
            ],
            [
                'name' => 'Perpustakaan',
                'description' => 'Perpustakaan dengan koleksi buku yang lengkap',
                'image' => 'perpustakaan.jpg',
                'capacity' => 50,
                'is_available' => true,
            ],
            [
                'name' => 'Lapangan Olahraga',
                'description' => 'Lapangan olahraga untuk berbagai kegiatan olahraga',
                'image' => 'lapangan-olahraga.jpg',
                'capacity' => 100,
                'is_available' => true,
            ],
            [
                'name' => 'Aula',
                'description' => 'Aula untuk berbagai acara dan pertemuan',
                'image' => 'aula.jpg',
                'capacity' => 200,
                'is_available' => true,
            ],
            [
                'name' => 'Kantin',
                'description' => 'Kantin sekolah dengan berbagai menu sehat',
                'image' => 'kantin.jpg',
                'capacity' => 80,
                'is_available' => true,
            ],
            [
                'name' => 'Ruang UKS',
                'description' => 'Unit Kesehatan Sekolah untuk pelayanan kesehatan siswa',
                'image' => 'uks.jpg',
                'capacity' => 10,
                'is_available' => true,
            ],
            [
                'name' => 'Ruang BK',
                'description' => 'Ruang Bimbingan dan Konseling untuk konsultasi siswa',
                'image' => 'ruang-bk.jpg',
                'capacity' => 15,
                'is_available' => true,
            ],
        ];

        foreach ($facilities as $facility) {
            \App\Models\Facility::create($facility);
        }
    }
}
