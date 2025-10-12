<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Pendidikan',
            'Sekolah',
            'Kegiatan',
            'Prestasi',
            'Ekstrakurikuler',
            'Guru',
            'Siswa',
            'Olahraga',
            'Seni',
            'Teknologi',
            'Berita',
            'Pengumuman',
            'Acara',
            'Lomba',
            'Peringatan',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => \Illuminate\Support\Str::slug($tag),
            ]);
        }
    }
}

