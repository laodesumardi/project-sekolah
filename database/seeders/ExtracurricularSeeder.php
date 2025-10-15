<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Extracurricular;
use App\Models\ExtracurricularImage;
use App\Models\ExtracurricularAchievement;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExtracurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Extracurricular::query()->delete();
        ExtracurricularImage::query()->delete();
        ExtracurricularAchievement::query()->delete();
        
        // Reset auto increment
        DB::statement('ALTER TABLE extracurriculars AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE extracurricular_images AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE extracurricular_achievements AUTO_INCREMENT = 1');

        // Get first teacher as instructor
        $teacher = Teacher::first();
        $admin = User::where('role', 'admin')->first();

        $extracurriculars = [
            [
                'name' => 'Basket Putra',
                'category' => 'olahraga',
                'description' => 'Ekstrakurikuler basket putra adalah kegiatan olahraga yang mengembangkan kemampuan bermain basket, kerja sama tim, dan kebugaran fisik. Melalui latihan rutin dan kompetisi, siswa akan belajar teknik dasar basket, strategi permainan, dan nilai-nilai sportivitas.',
                'short_description' => 'Kembangkan kemampuan bermain basket dan kerja sama tim melalui latihan rutin dan kompetisi.',
                'instructor_id' => $teacher?->id,
                'instructor_name' => $teacher ? null : 'Budi Santoso, S.Pd',
                'schedule_day' => 'senin',
                'schedule_time_start' => '15:00',
                'schedule_time_end' => '17:00',
                'location' => 'Lapangan Basket',
                'max_participants' => 20,
                'current_participants' => 15,
                'is_registration_open' => true,
                'registration_start' => now()->subDays(30),
                'registration_end' => now()->addDays(30),
                'requirements' => json_encode(['Tinggi minimal 160cm', 'Membawa sepatu olahraga', 'Kondisi fisik sehat']),
                'benefits' => json_encode(['Meningkatkan kebugaran fisik', 'Mengembangkan kerja sama tim', 'Mengasah kemampuan strategi']),
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'view_count' => 150,
                'facebook_url' => 'https://facebook.com/basketputra',
                'instagram_url' => 'https://instagram.com/basketputra',
                'created_by' => $admin?->id,
                'updated_by' => $admin?->id,
            ],
            [
                'name' => 'Paduan Suara',
                'category' => 'seni',
                'description' => 'Ekstrakurikuler paduan suara mengembangkan kemampuan vokal, harmonisasi, dan ekspresi musikal siswa. Melalui latihan rutin, siswa akan belajar teknik bernyanyi, membaca notasi musik, dan tampil di berbagai acara sekolah.',
                'short_description' => 'Kembangkan kemampuan vokal dan harmonisasi melalui latihan paduan suara yang menyenangkan.',
                'instructor_id' => $teacher?->id,
                'instructor_name' => $teacher ? null : 'Sari Indah, S.Pd',
                'schedule_day' => 'rabu',
                'schedule_time_start' => '14:00',
                'schedule_time_end' => '16:00',
                'location' => 'Ruang Musik',
                'max_participants' => 30,
                'current_participants' => 25,
                'is_registration_open' => true,
                'registration_start' => now()->subDays(20),
                'registration_end' => now()->addDays(40),
                'requirements' => json_encode(['Minat terhadap musik', 'Kemampuan bernyanyi dasar', 'Disiplin dalam latihan']),
                'benefits' => json_encode(['Mengembangkan kemampuan vokal', 'Meningkatkan kepercayaan diri', 'Belajar kerja sama dalam tim']),
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'view_count' => 120,
                'instagram_url' => 'https://instagram.com/paduansuara',
                'created_by' => $admin?->id,
                'updated_by' => $admin?->id,
            ],
            [
                'name' => 'Robotik',
                'category' => 'teknologi',
                'description' => 'Ekstrakurikuler robotik mengajarkan siswa tentang pemrograman, elektronika, dan mekanika robot. Siswa akan belajar membuat robot sederhana, memprogramnya, dan berpartisipasi dalam kompetisi robotik tingkat regional dan nasional.',
                'short_description' => 'Pelajari teknologi robotik, pemrograman, dan elektronika melalui proyek-proyek menarik.',
                'instructor_id' => $teacher?->id,
                'instructor_name' => $teacher ? null : 'Ahmad Rizki, S.T',
                'schedule_day' => 'jumat',
                'schedule_time_start' => '13:00',
                'schedule_time_end' => '15:00',
                'location' => 'Lab Komputer',
                'max_participants' => 15,
                'current_participants' => 12,
                'is_registration_open' => true,
                'registration_start' => now()->subDays(10),
                'registration_end' => now()->addDays(50),
                'requirements' => json_encode(['Minat terhadap teknologi', 'Kemampuan logika dasar', 'Kesabaran dalam belajar']),
                'benefits' => json_encode(['Menguasai teknologi robotik', 'Mengembangkan kemampuan logika', 'Mempersiapkan masa depan teknologi']),
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'view_count' => 80,
                'youtube_url' => 'https://youtube.com/robotik',
                'created_by' => $admin?->id,
                'updated_by' => $admin?->id,
            ],
            [
                'name' => 'Pramuka',
                'category' => 'sosial',
                'description' => 'Ekstrakurikuler pramuka mengembangkan karakter kepemimpinan, kemandirian, dan kepedulian sosial siswa. Melalui berbagai kegiatan outdoor dan permainan, siswa akan belajar survival, kepemimpinan, dan nilai-nilai kebangsaan.',
                'short_description' => 'Kembangkan karakter kepemimpinan dan kemandirian melalui kegiatan pramuka yang menantang.',
                'instructor_id' => $teacher?->id,
                'instructor_name' => $teacher ? null : 'Dedi Kurniawan, S.Pd',
                'schedule_day' => 'sabtu',
                'schedule_time_start' => '08:00',
                'schedule_time_end' => '12:00',
                'location' => 'Lapangan Sekolah',
                'max_participants' => 50,
                'current_participants' => 45,
                'is_registration_open' => true,
                'registration_start' => now()->subDays(15),
                'registration_end' => now()->addDays(35),
                'requirements' => json_encode(['Kesehatan fisik baik', 'Minat kegiatan outdoor', 'Disiplin tinggi']),
                'benefits' => json_encode(['Mengembangkan kepemimpinan', 'Meningkatkan kemandirian', 'Belajar survival dan teamwork']),
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4,
                'view_count' => 200,
                'created_by' => $admin?->id,
                'updated_by' => $admin?->id,
            ],
            [
                'name' => 'Bahasa Inggris',
                'category' => 'bahasa',
                'description' => 'Ekstrakurikuler bahasa Inggris mengembangkan kemampuan komunikasi dalam bahasa Inggris melalui berbagai aktivitas menarik seperti debat, drama, dan presentasi. Siswa akan belajar grammar, vocabulary, dan speaking dengan metode yang menyenangkan.',
                'short_description' => 'Tingkatkan kemampuan bahasa Inggris melalui aktivitas debat, drama, dan presentasi yang menarik.',
                'instructor_id' => $teacher?->id,
                'instructor_name' => $teacher ? null : 'Maria Sari, S.Pd',
                'schedule_day' => 'selasa',
                'schedule_time_start' => '15:30',
                'schedule_time_end' => '17:30',
                'location' => 'Ruang Bahasa',
                'max_participants' => 25,
                'current_participants' => 20,
                'is_registration_open' => true,
                'registration_start' => now()->subDays(25),
                'registration_end' => now()->addDays(25),
                'requirements' => json_encode(['Minat belajar bahasa', 'Kemampuan dasar bahasa Inggris', 'Keberanian berbicara']),
                'benefits' => json_encode(['Meningkatkan kemampuan bahasa Inggris', 'Mengembangkan kepercayaan diri', 'Mempersiapkan masa depan global']),
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
                'view_count' => 90,
                'created_by' => $admin?->id,
                'updated_by' => $admin?->id,
            ]
        ];

        foreach ($extracurriculars as $data) {
            $extracurricular = Extracurricular::create($data);

            // Create sample achievements
            if ($extracurricular->name === 'Basket Putra') {
                ExtracurricularAchievement::create([
                    'extracurricular_id' => $extracurricular->id,
                    'title' => 'Juara 1 Turnamen Basket Antar Sekolah',
                    'description' => 'Tim basket putra berhasil meraih juara 1 dalam turnamen basket antar sekolah tingkat kecamatan.',
                    'achievement_level' => 'kecamatan',
                    'rank' => 'Juara 1',
                    'event_name' => 'Turnamen Basket Antar Sekolah',
                    'date' => now()->subDays(60),
                    'participants' => json_encode(['Ahmad Rizki', 'Budi Santoso', 'Candra Wijaya']),
                    'sort_order' => 1,
                ]);
            }

            if ($extracurricular->name === 'Paduan Suara') {
                ExtracurricularAchievement::create([
                    'extracurricular_id' => $extracurricular->id,
                    'title' => 'Juara 2 Festival Paduan Suara',
                    'description' => 'Paduan suara sekolah berhasil meraih juara 2 dalam festival paduan suara tingkat kabupaten.',
                    'achievement_level' => 'kota',
                    'rank' => 'Juara 2',
                    'event_name' => 'Festival Paduan Suara Kabupaten',
                    'date' => now()->subDays(45),
                    'participants' => json_encode(['Sari Indah', 'Maya Sari', 'Dewi Lestari']),
                    'sort_order' => 1,
                ]);
            }

            if ($extracurricular->name === 'Robotik') {
                ExtracurricularAchievement::create([
                    'extracurricular_id' => $extracurricular->id,
                    'title' => 'Juara 3 Kompetisi Robotik Regional',
                    'description' => 'Tim robotik berhasil meraih juara 3 dalam kompetisi robotik tingkat regional.',
                    'achievement_level' => 'provinsi',
                    'rank' => 'Juara 3',
                    'event_name' => 'Kompetisi Robotik Regional',
                    'date' => now()->subDays(30),
                    'participants' => json_encode(['Ahmad Rizki', 'Budi Santoso', 'Candra Wijaya']),
                    'sort_order' => 1,
                ]);
            }
        }

        $this->command->info('Extracurricular data seeded successfully!');
    }
}
