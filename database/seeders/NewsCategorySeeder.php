<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Berita Sekolah',
                'slug' => 'berita-sekolah',
                'description' => 'Berita terkini tentang kegiatan dan perkembangan sekolah',
            ],
            [
                'name' => 'Prestasi',
                'slug' => 'prestasi',
                'description' => 'Berita tentang prestasi siswa dan sekolah',
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
                'description' => 'Berita tentang berbagai kegiatan sekolah',
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman resmi dari sekolah',
            ],
            [
                'name' => 'PPDB',
                'slug' => 'ppdb',
                'description' => 'Informasi tentang Penerimaan Peserta Didik Baru',
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\NewsCategory::create($category);
        }
    }
}
