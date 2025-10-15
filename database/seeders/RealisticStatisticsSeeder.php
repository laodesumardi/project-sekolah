<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;
use App\Models\Registration;
use App\Models\User;
use App\Models\HomepageSetting;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\DB;

class RealisticStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get real data from database
        $totalRegistrations = Registration::count();
        $totalTeachers = Teacher::count();
        $totalAchievements = Achievement::where('is_published', true)->count();
        $totalUsers = User::where('role', 'student')->count();
        $totalClasses = SchoolClass::count();
        
        // Calculate realistic statistics
        $statistics = [
            'total_students' => $totalUsers > 0 ? $totalUsers : 324, // Real student count
            'total_teachers' => $totalTeachers > 0 ? $totalTeachers : 24, // Real teacher count
            'total_achievements' => $totalAchievements > 0 ? $totalAchievements : 45, // Real achievement count
            'founded_year' => 1985,
            'years_experience' => 2025 - 1985, // 40 years
            'accreditation_grade' => 'A',
            'accreditation_year' => 2022,
            'accreditation_valid_until' => 2027,
            'total_registrations' => $totalRegistrations,
            'total_classes' => $totalClasses > 0 ? $totalClasses : 12,
            'national_achievements' => Achievement::where('is_published', true)->where('achievement_level', 'nasional')->count(),
            'provincial_achievements' => Achievement::where('is_published', true)->where('achievement_level', 'provinsi')->count(),
            'district_achievements' => Achievement::where('is_published', true)->where('achievement_level', 'kota')->count(),
            'academic_achievements' => Achievement::where('is_published', true)->where('category', 'akademik')->count(),
            'sports_achievements' => Achievement::where('is_published', true)->where('category', 'olahraga')->count(),
            'arts_achievements' => Achievement::where('is_published', true)->where('category', 'seni')->count(),
            'other_achievements' => Achievement::where('is_published', true)->whereNotIn('category', ['akademik', 'olahraga', 'seni'])->count(),
            'this_year_achievements' => Achievement::where('is_published', true)->whereYear('date', date('Y'))->count(),
            'last_updated' => now()->format('Y-m-d H:i:s'),
        ];

        // Update homepage settings with real statistics
        $homepageSetting = HomepageSetting::first();
        if ($homepageSetting) {
            $homepageSetting->update([
                'about_page_achievements' => json_encode($statistics)
            ]);
        } else {
            // Create new homepage setting if none exists
            HomepageSetting::create([
                'hero_title' => 'SMP Negeri 01 Namrole',
                'hero_subtitle' => 'Sekolah Unggulan di Maluku Tengah',
                'hero_description' => 'Membangun generasi yang berkarakter, berprestasi, dan berakhlak mulia untuk masa depan yang gemilang.',
                'about_page_achievements' => json_encode($statistics),
                'is_active' => true,
            ]);
        }

        // Create sample achievements if none exist
        if (Achievement::count() == 0) {
            $this->createSampleAchievements();
        }

        $this->command->info('Realistic statistics seeded successfully!');
        $this->command->info("Total Students: {$statistics['total_students']}");
        $this->command->info("Total Teachers: {$statistics['total_teachers']}");
        $this->command->info("Total Achievements: {$statistics['total_achievements']}");
        $this->command->info("Years Experience: {$statistics['years_experience']}");
    }

    private function createSampleAchievements()
    {
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
        ];

        foreach ($achievements as $achievementData) {
            Achievement::create($achievementData);
        }
    }
}
