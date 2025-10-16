<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicCalendar;
use App\Models\AcademicYear;

class AcademicCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = AcademicYear::where('is_active', true)->first();
        
        if (!$academicYear) {
            $this->command->warn('No active academic year found. Please run AcademicYearSeeder first.');
            return;
        }

        $events = [
            [
                'title' => 'Awal Tahun Ajaran Baru',
                'description' => 'Hari pertama masuk sekolah untuk tahun ajaran baru',
                'event_type' => 'activity',
                'start_date' => '2024-07-15',
                'end_date' => '2024-07-15',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#2563EB',
                'is_all_day' => false,
            ],
            [
                'title' => 'Ujian Tengah Semester Ganjil',
                'description' => 'Pelaksanaan ujian tengah semester untuk semester ganjil',
                'event_type' => 'exam',
                'start_date' => '2024-09-16',
                'end_date' => '2024-09-23',
                'start_time' => null,
                'end_time' => null,
                'location' => 'Ruang Kelas',
                'color' => '#DC2626',
                'is_all_day' => true,
            ],
            [
                'title' => 'Libur Semester Ganjil',
                'description' => 'Libur semester ganjil',
                'event_type' => 'holiday',
                'start_date' => '2024-12-23',
                'end_date' => '2025-01-05',
                'start_time' => null,
                'end_time' => null,
                'location' => null,
                'color' => '#16A34A',
                'is_all_day' => true,
            ],
            [
                'title' => 'Ujian Akhir Semester Ganjil',
                'description' => 'Pelaksanaan ujian akhir semester untuk semester ganjil',
                'event_type' => 'exam',
                'start_date' => '2024-12-09',
                'end_date' => '2024-12-16',
                'start_time' => null,
                'end_time' => null,
                'location' => 'Ruang Kelas',
                'color' => '#DC2626',
                'is_all_day' => true,
            ],
            [
                'title' => 'Awal Semester Genap',
                'description' => 'Hari pertama masuk sekolah untuk semester genap',
                'event_type' => 'activity',
                'start_date' => '2025-01-06',
                'end_date' => '2025-01-06',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#2563EB',
                'is_all_day' => false,
            ],
            [
                'title' => 'Ujian Tengah Semester Genap',
                'description' => 'Pelaksanaan ujian tengah semester untuk semester genap',
                'event_type' => 'exam',
                'start_date' => '2025-03-10',
                'end_date' => '2025-03-17',
                'start_time' => null,
                'end_time' => null,
                'location' => 'Ruang Kelas',
                'color' => '#DC2626',
                'is_all_day' => true,
            ],
            [
                'title' => 'Ujian Akhir Semester Genap',
                'description' => 'Pelaksanaan ujian akhir semester untuk semester genap',
                'event_type' => 'exam',
                'start_date' => '2025-06-02',
                'end_date' => '2025-06-09',
                'start_time' => null,
                'end_time' => null,
                'location' => 'Ruang Kelas',
                'color' => '#DC2626',
                'is_all_day' => true,
            ],
            [
                'title' => 'Libur Akhir Tahun Ajaran',
                'description' => 'Libur akhir tahun ajaran',
                'event_type' => 'holiday',
                'start_date' => '2025-06-23',
                'end_date' => '2025-07-14',
                'start_time' => null,
                'end_time' => null,
                'location' => null,
                'color' => '#16A34A',
                'is_all_day' => true,
            ],
            [
                'title' => 'Deadline Pengumpulan Raport',
                'description' => 'Batas akhir pengumpulan raport semester ganjil',
                'event_type' => 'deadline',
                'start_date' => '2024-12-20',
                'end_date' => '2024-12-20',
                'start_time' => null,
                'end_time' => null,
                'location' => 'Ruang Guru',
                'color' => '#F59E0B',
                'is_all_day' => true,
            ],
            [
                'title' => 'Perayaan HUT RI',
                'description' => 'Upacara dan kegiatan perayaan HUT RI ke-79',
                'event_type' => 'activity',
                'start_date' => '2024-08-17',
                'end_date' => '2024-08-17',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'Lapangan Upacara',
                'color' => '#2563EB',
                'is_all_day' => false,
            ],
        ];

        foreach ($events as $event) {
            $event['academic_year_id'] = $academicYear->id;
            AcademicCalendar::create($event);
        }

        $this->command->info('Academic calendar events have been seeded successfully.');
    }
}
