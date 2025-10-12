<?php

namespace Database\Seeders;

use App\Models\Extracurricular;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class ExtracurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some teachers to assign as instructors
        $teachers = Teacher::with('user')->get();
        
        $extracurriculars = [
            // Olahraga
            [
                'name' => 'Sepak Bola',
                'description' => 'Ekstrakurikuler sepak bola untuk mengembangkan kemampuan olahraga dan kerja sama tim.',
                'category' => 'Olahraga',
                'schedule_day' => 'monday',
                'schedule_time' => '15:00',
                'instructor_id' => $teachers->where('subject', 'like', '%PJOK%')->first()?->id,
                'max_participants' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Basket',
                'description' => 'Ekstrakurikuler basket untuk mengembangkan kemampuan olahraga dan kerja sama tim.',
                'category' => 'Olahraga',
                'schedule_day' => 'tuesday',
                'schedule_time' => '15:00',
                'instructor_id' => $teachers->where('subject', 'like', '%PJOK%')->first()?->id,
                'max_participants' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Voli',
                'description' => 'Ekstrakurikuler voli untuk mengembangkan kemampuan olahraga dan kerja sama tim.',
                'category' => 'Olahraga',
                'schedule_day' => 'wednesday',
                'schedule_time' => '15:00',
                'instructor_id' => $teachers->where('subject', 'like', '%PJOK%')->first()?->id,
                'max_participants' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'Bulu Tangkis',
                'description' => 'Ekstrakurikuler bulu tangkis untuk mengembangkan kemampuan olahraga individual.',
                'category' => 'Olahraga',
                'schedule_day' => 'thursday',
                'schedule_time' => '15:00',
                'instructor_id' => $teachers->where('subject', 'like', '%PJOK%')->first()?->id,
                'max_participants' => 16,
                'is_active' => true,
            ],
            [
                'name' => 'Renang',
                'description' => 'Ekstrakurikuler renang untuk mengembangkan kemampuan olahraga air.',
                'category' => 'Olahraga',
                'schedule_day' => 'friday',
                'schedule_time' => '15:00',
                'instructor_id' => $teachers->where('subject', 'like', '%PJOK%')->first()?->id,
                'max_participants' => 10,
                'is_active' => true,
            ],

            // Seni
            [
                'name' => 'Tari Tradisional',
                'description' => 'Ekstrakurikuler tari tradisional untuk melestarikan budaya Indonesia.',
                'category' => 'Seni',
                'schedule_day' => 'monday',
                'schedule_time' => '16:00',
                'instructor_id' => $teachers->where('subject', 'like', '%Seni%')->first()?->id,
                'max_participants' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Musik',
                'description' => 'Ekstrakurikuler musik untuk mengembangkan bakat seni musik siswa.',
                'category' => 'Seni',
                'schedule_day' => 'tuesday',
                'schedule_time' => '16:00',
                'instructor_id' => $teachers->where('subject', 'like', '%Seni%')->first()?->id,
                'max_participants' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Teater',
                'description' => 'Ekstrakurikuler teater untuk mengembangkan kemampuan seni peran.',
                'category' => 'Seni',
                'schedule_day' => 'wednesday',
                'schedule_time' => '16:00',
                'instructor_id' => $teachers->where('subject', 'like', '%Seni%')->first()?->id,
                'max_participants' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'Lukis',
                'description' => 'Ekstrakurikuler lukis untuk mengembangkan bakat seni rupa siswa.',
                'category' => 'Seni',
                'schedule_day' => 'thursday',
                'schedule_time' => '16:00',
                'instructor_id' => $teachers->where('subject', 'like', '%Seni%')->first()?->id,
                'max_participants' => 18,
                'is_active' => true,
            ],

            // Akademik
            [
                'name' => 'Olimpiade Matematika',
                'description' => 'Ekstrakurikuler olimpiade matematika untuk mengembangkan kemampuan matematika siswa.',
                'category' => 'Akademik',
                'schedule_day' => 'monday',
                'schedule_time' => '14:00',
                'instructor_id' => $teachers->where('subject', 'like', '%Matematika%')->first()?->id,
                'max_participants' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Olimpiade IPA',
                'description' => 'Ekstrakurikuler olimpiade IPA untuk mengembangkan kemampuan sains siswa.',
                'category' => 'Akademik',
                'schedule_day' => 'tuesday',
                'schedule_time' => '14:00',
                'instructor_id' => $teachers->where('subject', 'like', '%IPA%')->first()?->id,
                'max_participants' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Debat Bahasa Inggris',
                'description' => 'Ekstrakurikuler debat bahasa Inggris untuk mengembangkan kemampuan berbahasa Inggris.',
                'category' => 'Akademik',
                'schedule_day' => 'wednesday',
                'schedule_time' => '14:00',
                'instructor_id' => $teachers->where('subject', 'like', '%Bahasa Inggris%')->first()?->id,
                'max_participants' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'Jurnalistik',
                'description' => 'Ekstrakurikuler jurnalistik untuk mengembangkan kemampuan menulis dan komunikasi.',
                'category' => 'Akademik',
                'schedule_day' => 'thursday',
                'schedule_time' => '14:00',
                'instructor_id' => $teachers->where('subject', 'like', '%Bahasa Indonesia%')->first()?->id,
                'max_participants' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Robotik',
                'description' => 'Ekstrakurikuler robotik untuk mengembangkan kemampuan teknologi dan inovasi.',
                'category' => 'Akademik',
                'schedule_day' => 'friday',
                'schedule_time' => '14:00',
                'instructor_id' => $teachers->where('subject', 'like', '%Informatika%')->first()?->id,
                'max_participants' => 12,
                'is_active' => true,
            ],

            // Keagamaan
            [
                'name' => 'Tahfidz Al-Quran',
                'description' => 'Ekstrakurikuler tahfidz Al-Quran untuk menghafal dan memahami Al-Quran.',
                'category' => 'Keagamaan',
                'schedule_day' => 'monday',
                'schedule_time' => '13:00',
                'instructor_id' => $teachers->where('subject', 'like', '%PAI%')->first()?->id,
                'max_participants' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Qiroah',
                'description' => 'Ekstrakurikuler qiroah untuk mengembangkan kemampuan membaca Al-Quran dengan baik.',
                'category' => 'Keagamaan',
                'schedule_day' => 'tuesday',
                'schedule_time' => '13:00',
                'instructor_id' => $teachers->where('subject', 'like', '%PAI%')->first()?->id,
                'max_participants' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Kajian Islam',
                'description' => 'Ekstrakurikuler kajian Islam untuk memperdalam pemahaman agama Islam.',
                'category' => 'Keagamaan',
                'schedule_day' => 'wednesday',
                'schedule_time' => '13:00',
                'instructor_id' => $teachers->where('subject', 'like', '%PAI%')->first()?->id,
                'max_participants' => 30,
                'is_active' => true,
            ],

            // Lain-lain
            [
                'name' => 'Pramuka',
                'description' => 'Ekstrakurikuler pramuka untuk mengembangkan karakter dan kepemimpinan siswa.',
                'category' => 'Lain-lain',
                'schedule_day' => 'saturday',
                'schedule_time' => '08:00',
                'instructor_id' => $teachers->first()?->id,
                'max_participants' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Paskibra',
                'description' => 'Ekstrakurikuler paskibra untuk mengembangkan disiplin dan nasionalisme siswa.',
                'category' => 'Lain-lain',
                'schedule_day' => 'friday',
                'schedule_time' => '15:00',
                'instructor_id' => $teachers->where('subject', 'like', '%PPKn%')->first()?->id,
                'max_participants' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'PMR (Palang Merah Remaja)',
                'description' => 'Ekstrakurikuler PMR untuk mengembangkan kemampuan pertolongan pertama dan kemanusiaan.',
                'category' => 'Lain-lain',
                'schedule_day' => 'thursday',
                'schedule_time' => '15:00',
                'instructor_id' => $teachers->where('subject', 'like', '%PJOK%')->first()?->id,
                'max_participants' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Karya Ilmiah Remaja',
                'description' => 'Ekstrakurikuler KIR untuk mengembangkan kemampuan penelitian dan penulisan ilmiah.',
                'category' => 'Lain-lain',
                'schedule_day' => 'friday',
                'schedule_time' => '14:00',
                'instructor_id' => $teachers->where('subject', 'like', '%IPA%')->first()?->id,
                'max_participants' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($extracurriculars as $extracurricular) {
            Extracurricular::create($extracurricular);
        }
    }
}

