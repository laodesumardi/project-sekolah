<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;
use App\Models\AchievementParticipant;
use App\Models\AchievementTeacher;
use Illuminate\Support\Facades\DB;

class AchievementSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Achievement::truncate();
        AchievementParticipant::truncate();
        AchievementTeacher::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $achievements = [
            [
                'title' => 'Juara 1 Olimpiade Matematika Nasional',
                'slug' => 'juara-1-olimpiade-matematika-nasional-1',
                'category' => 'akademik',
                'description' => 'Meraih juara 1 dalam Olimpiade Matematika Nasional tingkat SMA',
                'achievement_level' => 'nasional',
                'rank' => 'Juara 1',
                'event_name' => 'Olimpiade Matematika Nasional 2024',
                'organizer' => 'Kementerian Pendidikan dan Kebudayaan',
                'location' => 'Jakarta',
                'date' => '2024-03-15',
                'year' => 2024,
                'participant_type' => 'individu',
                'participants' => 'Ahmad Rizki',
                'student_ids' => null,
                'teacher_ids' => null,
                'certificate_image' => 'sample_certificate_1.jpg',
                'trophy_image' => 'sample_trophy_1.jpg',
                'documentation_images' => json_encode(['sample_doc_1.jpg', 'sample_doc_2.jpg']),
                'video_url' => 'https://youtube.com/watch?v=sample1',
                'news_url' => 'https://example.com/news/sample1',
                'prize' => 'Rp 5.000.000 + Laptop',
                'score' => '95',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
                'view_count' => 150,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Juara 2 Lomba Cerdas Cermat',
                'slug' => 'juara-2-lomba-cerdas-cermat-2',
                'category' => 'akademik',
                'description' => 'Meraih juara 2 dalam Lomba Cerdas Cermat tingkat provinsi',
                'achievement_level' => 'provinsi',
                'rank' => 'Juara 2',
                'event_name' => 'Lomba Cerdas Cermat Provinsi 2024',
                'organizer' => 'Dinas Pendidikan Provinsi',
                'location' => 'Bandung',
                'date' => '2024-02-20',
                'year' => 2024,
                'participant_type' => 'kelompok',
                'participants' => 'Tim Cerdas Cermat SMP Negeri 01 Namrole',
                'student_ids' => null,
                'teacher_ids' => null,
                'certificate_image' => 'sample_certificate_2.jpg',
                'trophy_image' => null,
                'documentation_images' => json_encode(['sample_doc_3.jpg']),
                'video_url' => null,
                'news_url' => null,
                'prize' => 'Rp 2.000.000 + Piagam',
                'score' => '88',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 2,
                'view_count' => 75,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Juara 1 Turnamen Sepak Bola',
                'slug' => 'juara-1-turnamen-sepak-bola-3',
                'category' => 'olahraga',
                'description' => 'Meraih juara 1 dalam Turnamen Sepak Bola antar sekolah',
                'achievement_level' => 'kota',
                'rank' => 'Juara 1',
                'event_name' => 'Turnamen Sepak Bola Kota 2024',
                'organizer' => 'Dinas Pemuda dan Olahraga',
                'location' => 'Lapangan Sepak Bola Kota',
                'date' => '2024-01-10',
                'year' => 2024,
                'participant_type' => 'tim',
                'participants' => 'Tim Sepak Bola SMP Negeri 01 Namrole',
                'student_ids' => null,
                'teacher_ids' => null,
                'certificate_image' => null,
                'trophy_image' => 'sample_trophy_2.jpg',
                'documentation_images' => json_encode(['sample_doc_4.jpg', 'sample_doc_5.jpg', 'sample_doc_6.jpg']),
                'video_url' => 'https://youtube.com/watch?v=sample2',
                'news_url' => 'https://example.com/news/sample2',
                'prize' => 'Piala + Rp 3.000.000',
                'score' => null,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
                'view_count' => 200,
                'created_by' => 1,
                'updated_by' => 1,
            ]
        ];

        foreach ($achievements as $index => $achievementData) {
            $achievement = Achievement::create($achievementData);

            // Add participants
            AchievementParticipant::create([
                'achievement_id' => $achievement->id,
                'student_id' => null,
                'participant_name' => 'Nama Siswa ' . ($index + 1),
                'role' => 'peserta',
                'class_name' => 'IX A'
            ]);

            // Add teachers
            AchievementTeacher::create([
                'achievement_id' => $achievement->id,
                'teacher_id' => 1,
                'role' => 'pembimbing'
            ]);
        }
    }
}


