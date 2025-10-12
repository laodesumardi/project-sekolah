<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicCalendar;
use App\Models\AcademicYear;
use Carbon\Carbon;

class CalendarEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get active academic year
        $academicYear = AcademicYear::where('is_active', true)->first();
        
        if (!$academicYear) {
            $this->command->error('No active academic year found');
            return;
        }

        // Clear existing events
        AcademicCalendar::truncate();

        // Create sample events with different colors
        $events = [
            [
                'title' => 'Ujian Tengah Semester',
                'description' => 'Ujian tengah semester untuk semua mata pelajaran',
                'event_type' => 'exam',
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(7),
                'start_time' => '08:00',
                'end_time' => '12:00',
                'location' => 'Ruang Kelas',
                'color' => '#DC2626', // Red
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Kegiatan Pramuka',
                'description' => 'Latihan rutin pramuka setiap minggu',
                'event_type' => 'activity',
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(10),
                'start_time' => '14:00',
                'end_time' => '16:00',
                'location' => 'Lapangan Sekolah',
                'color' => '#2563EB', // Blue
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Hari Libur Nasional',
                'description' => 'Hari libur nasional',
                'event_type' => 'holiday',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(15),
                'start_time' => null,
                'end_time' => null,
                'location' => null,
                'color' => '#16A34A', // Green
                'academic_year_id' => $academicYear->id,
                'is_all_day' => true,
            ],
            [
                'title' => 'Deadline Pengumpulan Tugas',
                'description' => 'Batas waktu pengumpulan tugas proyek',
                'event_type' => 'deadline',
                'start_date' => Carbon::now()->addDays(20),
                'end_date' => Carbon::now()->addDays(20),
                'start_time' => '23:59',
                'end_time' => '23:59',
                'location' => 'Online',
                'color' => '#D97706', // Yellow
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Rapat Guru',
                'description' => 'Rapat koordinasi guru bulanan',
                'event_type' => 'activity',
                'start_date' => Carbon::now()->addDays(25),
                'end_date' => Carbon::now()->addDays(25),
                'start_time' => '13:00',
                'end_time' => '15:00',
                'location' => 'Ruang Guru',
                'color' => '#7C3AED', // Purple
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ]
        ];

        foreach ($events as $eventData) {
            AcademicCalendar::create($eventData);
            $this->command->info("Created event: {$eventData['title']} with color: {$eventData['color']}");
        }

        $this->command->info('Created ' . count($events) . ' calendar events with colors');
    }
}
