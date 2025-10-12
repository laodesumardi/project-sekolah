<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            // Kelas 10
            [
                'name' => 'Pendidikan Agama Islam',
                'code' => 'PAI-10',
                'description' => 'Mata pelajaran yang membahas tentang ajaran Islam, akhlak, dan nilai-nilai keagamaan.',
                'grade_level' => '10',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Pendidikan Pancasila dan Kewarganegaraan',
                'code' => 'PPKn-10',
                'description' => 'Mata pelajaran yang membahas tentang nilai-nilai Pancasila dan kewarganegaraan.',
                'grade_level' => '10',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bahasa Indonesia',
                'code' => 'BIN-10',
                'description' => 'Mata pelajaran yang membahas tentang keterampilan berbahasa Indonesia.',
                'grade_level' => '10',
                'hours_per_week' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Matematika',
                'code' => 'MAT-10',
                'description' => 'Mata pelajaran yang membahas tentang konsep matematika dasar dan aplikasinya.',
                'grade_level' => '10',
                'hours_per_week' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Sejarah Indonesia',
                'code' => 'SEJ-10',
                'description' => 'Mata pelajaran yang membahas tentang sejarah perjuangan bangsa Indonesia.',
                'grade_level' => '10',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bahasa Inggris',
                'code' => 'BIG-10',
                'description' => 'Mata pelajaran yang membahas tentang keterampilan berbahasa Inggris.',
                'grade_level' => '10',
                'hours_per_week' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Seni Budaya',
                'code' => 'SB-10',
                'description' => 'Mata pelajaran yang membahas tentang seni dan budaya Indonesia.',
                'grade_level' => '10',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
                'code' => 'PJOK-10',
                'description' => 'Mata pelajaran yang membahas tentang kesehatan jasmani dan rohani.',
                'grade_level' => '10',
                'hours_per_week' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Informatika',
                'code' => 'INF-10',
                'description' => 'Mata pelajaran yang membahas tentang teknologi informasi dan komunikasi.',
                'grade_level' => '10',
                'hours_per_week' => 2,
                'is_active' => true,
            ],

            // Kelas 11
            [
                'name' => 'Pendidikan Agama Islam',
                'code' => 'PAI-11',
                'description' => 'Mata pelajaran yang membahas tentang ajaran Islam, akhlak, dan nilai-nilai keagamaan.',
                'grade_level' => '11',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Pendidikan Pancasila dan Kewarganegaraan',
                'code' => 'PPKn-11',
                'description' => 'Mata pelajaran yang membahas tentang nilai-nilai Pancasila dan kewarganegaraan.',
                'grade_level' => '11',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bahasa Indonesia',
                'code' => 'BIN-11',
                'description' => 'Mata pelajaran yang membahas tentang keterampilan berbahasa Indonesia.',
                'grade_level' => '11',
                'hours_per_week' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Matematika',
                'code' => 'MAT-11',
                'description' => 'Mata pelajaran yang membahas tentang konsep matematika lanjutan dan aplikasinya.',
                'grade_level' => '11',
                'hours_per_week' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Sejarah Indonesia',
                'code' => 'SEJ-11',
                'description' => 'Mata pelajaran yang membahas tentang sejarah perjuangan bangsa Indonesia.',
                'grade_level' => '11',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bahasa Inggris',
                'code' => 'BIG-11',
                'description' => 'Mata pelajaran yang membahas tentang keterampilan berbahasa Inggris.',
                'grade_level' => '11',
                'hours_per_week' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Seni Budaya',
                'code' => 'SB-11',
                'description' => 'Mata pelajaran yang membahas tentang seni dan budaya Indonesia.',
                'grade_level' => '11',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
                'code' => 'PJOK-11',
                'description' => 'Mata pelajaran yang membahas tentang kesehatan jasmani dan rohani.',
                'grade_level' => '11',
                'hours_per_week' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Informatika',
                'code' => 'INF-11',
                'description' => 'Mata pelajaran yang membahas tentang teknologi informasi dan komunikasi.',
                'grade_level' => '11',
                'hours_per_week' => 2,
                'is_active' => true,
            ],

            // Kelas 12
            [
                'name' => 'Pendidikan Agama Islam',
                'code' => 'PAI-12',
                'description' => 'Mata pelajaran yang membahas tentang ajaran Islam, akhlak, dan nilai-nilai keagamaan.',
                'grade_level' => '12',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Pendidikan Pancasila dan Kewarganegaraan',
                'code' => 'PPKn-12',
                'description' => 'Mata pelajaran yang membahas tentang nilai-nilai Pancasila dan kewarganegaraan.',
                'grade_level' => '12',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bahasa Indonesia',
                'code' => 'BIN-12',
                'description' => 'Mata pelajaran yang membahas tentang keterampilan berbahasa Indonesia.',
                'grade_level' => '12',
                'hours_per_week' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Matematika',
                'code' => 'MAT-12',
                'description' => 'Mata pelajaran yang membahas tentang konsep matematika tingkat lanjut dan aplikasinya.',
                'grade_level' => '12',
                'hours_per_week' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Sejarah Indonesia',
                'code' => 'SEJ-12',
                'description' => 'Mata pelajaran yang membahas tentang sejarah perjuangan bangsa Indonesia.',
                'grade_level' => '12',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bahasa Inggris',
                'code' => 'BIG-12',
                'description' => 'Mata pelajaran yang membahas tentang keterampilan berbahasa Inggris.',
                'grade_level' => '12',
                'hours_per_week' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Seni Budaya',
                'code' => 'SB-12',
                'description' => 'Mata pelajaran yang membahas tentang seni dan budaya Indonesia.',
                'grade_level' => '12',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan',
                'code' => 'PJOK-12',
                'description' => 'Mata pelajaran yang membahas tentang kesehatan jasmani dan rohani.',
                'grade_level' => '12',
                'hours_per_week' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Informatika',
                'code' => 'INF-12',
                'description' => 'Mata pelajaran yang membahas tentang teknologi informasi dan komunikasi.',
                'grade_level' => '12',
                'hours_per_week' => 2,
                'is_active' => true,
            ],

            // Mata Pelajaran untuk Semua Tingkat
            [
                'name' => 'Bimbingan Konseling',
                'code' => 'BK-ALL',
                'description' => 'Mata pelajaran yang membahas tentang bimbingan dan konseling siswa.',
                'grade_level' => 'all',
                'hours_per_week' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Pramuka',
                'code' => 'PRAMUKA-ALL',
                'description' => 'Kegiatan ekstrakurikuler wajib yang membentuk karakter siswa.',
                'grade_level' => 'all',
                'hours_per_week' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}

