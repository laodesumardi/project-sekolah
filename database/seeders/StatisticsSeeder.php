<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;
use App\Models\Registration;
use App\Models\User;
use App\Models\HomepageSetting;
use Illuminate\Support\Facades\DB;

class StatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update homepage settings with statistics
        $homepageSetting = HomepageSetting::first();
        if ($homepageSetting) {
            $homepageSetting->update([
                'about_page_achievements' => json_encode([
                    'total_students' => 1234,
                    'total_teachers' => 87,
                    'total_achievements' => 156,
                    'founded_year' => 1985,
                    'years_experience' => 2025 - 1985,
                    'accreditation_grade' => 'A',
                    'accreditation_year' => 2022,
                    'accreditation_valid_until' => 2027,
                    'national_achievements' => 45,
                    'provincial_achievements' => 67,
                    'district_achievements' => 44,
                    'academic_achievements' => 89,
                    'sports_achievements' => 34,
                    'arts_achievements' => 23,
                    'other_achievements' => 10,
                ])
            ]);
        }

        // Create sample achievements with realistic data
        $achievements = [
            [
                'title' => 'Juara 1 Olimpiade Matematika Nasional',
                'slug' => 'juara-1-olimpiade-matematika-nasional',
                'category' => 'akademik',
                'description' => 'Meraih juara 1 dalam Olimpiade Matematika Nasional tingkat SMP yang diselenggarakan oleh Kementerian Pendidikan dan Kebudayaan.',
                'achievement_level' => 'nasional',
                'rank' => 'Juara 1',
                'event_name' => 'Olimpiade Matematika Nasional 2024',
                'organizer' => 'Kementerian Pendidikan dan Kebudayaan',
                'location' => 'Jakarta',
                'date' => '2024-03-15',
                'year' => 2024,
                'participant_type' => 'individu',
                'student_ids' => null,
                'teacher_ids' => null,
                'certificate_image' => 'olimpiade_matematika_nasional_2024.jpg',
                'trophy_image' => 'trophy_olimpiade_matematika_2024.jpg',
                'documentation_images' => json_encode(['doc_olimpiade_1.jpg', 'doc_olimpiade_2.jpg', 'doc_olimpiade_3.jpg']),
                'video_url' => 'https://youtube.com/watch?v=olimpiade-matematika-2024',
                'news_url' => 'https://example.com/news/olimpiade-matematika-2024',
                'prize' => 'Rp 5.000.000 + Laptop + Beasiswa',
                'score' => '95',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
                'view_count' => 150,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Juara 2 Lomba Pidato Bahasa Indonesia Tingkat Provinsi',
                'slug' => 'juara-2-lomba-pidato-bahasa-indonesia-provinsi',
                'category' => 'akademik',
                'description' => 'Meraih juara 2 dalam Lomba Pidato Bahasa Indonesia tingkat Provinsi Maluku yang diselenggarakan oleh Dinas Pendidikan Provinsi.',
                'achievement_level' => 'provinsi',
                'rank' => 'Juara 2',
                'event_name' => 'Lomba Pidato Bahasa Indonesia Provinsi Maluku 2024',
                'organizer' => 'Dinas Pendidikan Provinsi Maluku',
                'location' => 'Ambon',
                'date' => '2024-02-20',
                'year' => 2024,
                'participant_type' => 'individu',
                'student_ids' => null,
                'teacher_ids' => null,
                'certificate_image' => 'pidato_bahasa_indonesia_provinsi_2024.jpg',
                'trophy_image' => 'trophy_pidato_provinsi_2024.jpg',
                'documentation_images' => json_encode(['doc_pidato_1.jpg', 'doc_pidato_2.jpg']),
                'video_url' => 'https://youtube.com/watch?v=pidato-bahasa-indonesia-2024',
                'news_url' => 'https://example.com/news/pidato-bahasa-indonesia-2024',
                'prize' => 'Rp 3.000.000 + Piala + Sertifikat',
                'score' => '88',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
                'view_count' => 120,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Juara 1 Turnamen Sepak Bola Pelajar Tingkat Kota',
                'slug' => 'juara-1-turnamen-sepak-bola-pelajar-kota',
                'category' => 'olahraga',
                'description' => 'Meraih juara 1 dalam Turnamen Sepak Bola Pelajar tingkat Kota yang diselenggarakan oleh Dinas Pemuda dan Olahraga.',
                'achievement_level' => 'kota',
                'rank' => 'Juara 1',
                'event_name' => 'Turnamen Sepak Bola Pelajar Kota 2024',
                'organizer' => 'Dinas Pemuda dan Olahraga',
                'location' => 'Lapangan Sepak Bola Kota',
                'date' => '2024-01-10',
                'year' => 2024,
                'participant_type' => 'tim',
                'student_ids' => null,
                'teacher_ids' => null,
                'certificate_image' => null,
                'trophy_image' => 'trophy_sepak_bola_kota_2024.jpg',
                'documentation_images' => json_encode(['doc_sepak_bola_1.jpg', 'doc_sepak_bola_2.jpg', 'doc_sepak_bola_3.jpg']),
                'video_url' => 'https://youtube.com/watch?v=sepak-bola-kota-2024',
                'news_url' => 'https://example.com/news/sepak-bola-kota-2024',
                'prize' => 'Piala + Rp 2.000.000 + Medali',
                'score' => null,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
                'view_count' => 200,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Juara 3 Lomba Seni Tari Tradisional Tingkat Nasional',
                'slug' => 'juara-3-lomba-seni-tari-tradisional-nasional',
                'category' => 'seni',
                'description' => 'Meraih juara 3 dalam Lomba Seni Tari Tradisional tingkat Nasional yang diselenggarakan oleh Kementerian Pendidikan dan Kebudayaan.',
                'achievement_level' => 'nasional',
                'rank' => 'Juara 3',
                'event_name' => 'Festival Seni Tradisional Nasional 2024',
                'organizer' => 'Kementerian Pendidikan dan Kebudayaan',
                'location' => 'Jakarta',
                'date' => '2024-04-05',
                'year' => 2024,
                'participant_type' => 'kelompok',
                'student_ids' => null,
                'teacher_ids' => null,
                'certificate_image' => 'tari_tradisional_nasional_2024.jpg',
                'trophy_image' => 'trophy_tari_nasional_2024.jpg',
                'documentation_images' => json_encode(['doc_tari_1.jpg', 'doc_tari_2.jpg', 'doc_tari_3.jpg', 'doc_tari_4.jpg']),
                'video_url' => 'https://youtube.com/watch?v=tari-tradisional-2024',
                'news_url' => 'https://example.com/news/tari-tradisional-2024',
                'prize' => 'Rp 2.000.000 + Piala + Sertifikat',
                'score' => null,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4,
                'view_count' => 180,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'title' => 'Juara 1 Lomba Karya Tulis Ilmiah Tingkat Provinsi',
                'slug' => 'juara-1-lomba-karya-tulis-ilmiah-provinsi',
                'category' => 'akademik',
                'description' => 'Meraih juara 1 dalam Lomba Karya Tulis Ilmiah tingkat Provinsi yang diselenggarakan oleh Dinas Pendidikan Provinsi Maluku.',
                'achievement_level' => 'provinsi',
                'rank' => 'Juara 1',
                'event_name' => 'Lomba Karya Tulis Ilmiah Provinsi Maluku 2024',
                'organizer' => 'Dinas Pendidikan Provinsi Maluku',
                'location' => 'Ambon',
                'date' => '2024-05-12',
                'year' => 2024,
                'participant_type' => 'individu',
                'student_ids' => null,
                'teacher_ids' => null,
                'certificate_image' => 'karya_tulis_ilmiah_provinsi_2024.jpg',
                'trophy_image' => 'trophy_karya_tulis_provinsi_2024.jpg',
                'documentation_images' => json_encode(['doc_karya_tulis_1.jpg', 'doc_karya_tulis_2.jpg']),
                'video_url' => 'https://youtube.com/watch?v=karya-tulis-ilmiah-2024',
                'news_url' => 'https://example.com/news/karya-tulis-ilmiah-2024',
                'prize' => 'Rp 4.000.000 + Laptop + Beasiswa',
                'score' => '92',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 5,
                'view_count' => 160,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        // Clear existing achievements
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Achievement::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Create achievements
        foreach ($achievements as $achievementData) {
            Achievement::create($achievementData);
        }

        $this->command->info('Statistics and achievements seeded successfully!');
    }
}
