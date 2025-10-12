<?php

namespace Database\Seeders;

use App\Models\AcademicCalendar;
use App\Models\AcademicYear;
use Illuminate\Database\Seeder;

class AcademicCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get active academic year
        $academicYear = AcademicYear::where('is_active', true)->first();
        
        if (!$academicYear) {
            return;
        }

        $events = [
            // Juli 2024
            [
                'title' => 'Hari Pertama Masuk Sekolah',
                'description' => 'Hari pertama masuk sekolah untuk tahun ajaran baru 2024/2025',
                'event_type' => 'activity',
                'start_date' => '2024-07-15',
                'end_date' => '2024-07-15',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#3B82F6',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Masa Orientasi Siswa (MOS)',
                'description' => 'Masa orientasi siswa baru untuk mengenalkan lingkungan sekolah',
                'event_type' => 'activity',
                'start_date' => '2024-07-16',
                'end_date' => '2024-07-18',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#10B981',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // Agustus 2024
            [
                'title' => 'Hari Kemerdekaan RI',
                'description' => 'Peringatan Hari Kemerdekaan Republik Indonesia ke-79',
                'event_type' => 'holiday',
                'start_date' => '2024-08-17',
                'end_date' => '2024-08-17',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#EF4444',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => true,
            ],
            [
                'title' => 'Upacara Bendera',
                'description' => 'Upacara bendera dalam rangka HUT RI ke-79',
                'event_type' => 'activity',
                'start_date' => '2024-08-17',
                'end_date' => '2024-08-17',
                'start_time' => '07:00',
                'end_time' => '08:00',
                'location' => 'Lapangan SMP Negeri 01 Namrole',
                'color' => '#3B82F6',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // September 2024
            [
                'title' => 'Ulangan Harian 1',
                'description' => 'Ulangan harian untuk semua mata pelajaran',
                'event_type' => 'exam',
                'start_date' => '2024-09-02',
                'end_date' => '2024-09-06',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#F59E0B',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Peringatan Hari Pendidikan Nasional',
                'description' => 'Upacara peringatan Hari Pendidikan Nasional',
                'event_type' => 'activity',
                'start_date' => '2024-09-02',
                'end_date' => '2024-09-02',
                'start_time' => '07:00',
                'end_time' => '08:00',
                'location' => 'Lapangan SMP Negeri 01 Namrole',
                'color' => '#8B5CF6',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // Oktober 2024
            [
                'title' => 'Ujian Tengah Semester (UTS)',
                'description' => 'Ujian Tengah Semester untuk semua kelas',
                'event_type' => 'exam',
                'start_date' => '2024-10-07',
                'end_date' => '2024-10-11',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#EF4444',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Pembagian Rapor Tengah Semester',
                'description' => 'Pembagian rapor hasil UTS kepada orang tua siswa',
                'event_type' => 'activity',
                'start_date' => '2024-10-18',
                'end_date' => '2024-10-18',
                'start_time' => '08:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#10B981',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // November 2024
            [
                'title' => 'Peringatan Hari Pahlawan',
                'description' => 'Upacara peringatan Hari Pahlawan',
                'event_type' => 'activity',
                'start_date' => '2024-11-10',
                'end_date' => '2024-11-10',
                'start_time' => '07:00',
                'end_time' => '08:00',
                'location' => 'Lapangan SMP Negeri 01 Namrole',
                'color' => '#3B82F6',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Lomba Antar Kelas',
                'description' => 'Lomba antar kelas dalam rangka memperingati Hari Pahlawan',
                'event_type' => 'activity',
                'start_date' => '2024-11-11',
                'end_date' => '2024-11-15',
                'start_time' => '07:00',
                'end_time' => '15:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#10B981',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // Desember 2024
            [
                'title' => 'Libur Semester 1',
                'description' => 'Libur akhir semester 1',
                'event_type' => 'holiday',
                'start_date' => '2024-12-23',
                'end_date' => '2025-01-05',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#6B7280',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => true,
            ],
            [
                'title' => 'Pembagian Rapor Semester 1',
                'description' => 'Pembagian rapor semester 1 kepada orang tua siswa',
                'event_type' => 'activity',
                'start_date' => '2024-12-20',
                'end_date' => '2024-12-20',
                'start_time' => '08:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#10B981',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // Januari 2025
            [
                'title' => 'Hari Pertama Masuk Semester 2',
                'description' => 'Hari pertama masuk sekolah semester 2',
                'event_type' => 'activity',
                'start_date' => '2025-01-06',
                'end_date' => '2025-01-06',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#3B82F6',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // Februari 2025
            [
                'title' => 'Ulangan Harian 2',
                'description' => 'Ulangan harian untuk semua mata pelajaran semester 2',
                'event_type' => 'exam',
                'start_date' => '2025-02-03',
                'end_date' => '2025-02-07',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#F59E0B',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // Maret 2025
            [
                'title' => 'Ujian Sekolah (US)',
                'description' => 'Ujian Sekolah untuk kelas 9',
                'event_type' => 'exam',
                'start_date' => '2025-03-10',
                'end_date' => '2025-03-14',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#EF4444',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Pembagian Rapor Ujian Sekolah',
                'description' => 'Pembagian rapor hasil Ujian Sekolah',
                'event_type' => 'activity',
                'start_date' => '2025-03-21',
                'end_date' => '2025-03-21',
                'start_time' => '08:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#10B981',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // April 2025
            [
                'title' => 'Ujian Nasional (UN)',
                'description' => 'Ujian Nasional untuk kelas 9',
                'event_type' => 'exam',
                'start_date' => '2025-04-07',
                'end_date' => '2025-04-11',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#EF4444',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Pembagian Rapor Ujian Nasional',
                'description' => 'Pembagian rapor hasil Ujian Nasional',
                'event_type' => 'activity',
                'start_date' => '2025-04-25',
                'end_date' => '2025-04-25',
                'start_time' => '08:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#10B981',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // Mei 2025
            [
                'title' => 'Ujian Akhir Semester (UAS)',
                'description' => 'Ujian Akhir Semester untuk kelas 7 dan 8',
                'event_type' => 'exam',
                'start_date' => '2025-05-05',
                'end_date' => '2025-05-09',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#F59E0B',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Pembagian Rapor Akhir Semester',
                'description' => 'Pembagian rapor akhir semester untuk kelas 7 dan 8',
                'event_type' => 'activity',
                'start_date' => '2025-05-16',
                'end_date' => '2025-05-16',
                'start_time' => '08:00',
                'end_time' => '12:00',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#10B981',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],

            // Juni 2025
            [
                'title' => 'Libur Semester 2',
                'description' => 'Libur akhir semester 2 dan tahun ajaran',
                'event_type' => 'holiday',
                'start_date' => '2025-06-16',
                'end_date' => '2025-06-30',
                'location' => 'SMP Negeri 01 Namrole',
                'color' => '#6B7280',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => true,
            ],

            // Event Deadline
            [
                'title' => 'Deadline Pengumpulan Tugas Akhir',
                'description' => 'Batas akhir pengumpulan tugas akhir semester',
                'event_type' => 'deadline',
                'start_date' => '2024-12-15',
                'end_date' => '2024-12-15',
                'start_time' => '23:59',
                'end_time' => '23:59',
                'location' => 'Online',
                'color' => '#F59E0B',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
            [
                'title' => 'Deadline Pendaftaran Ekstrakurikuler',
                'description' => 'Batas akhir pendaftaran ekstrakurikuler semester 2',
                'event_type' => 'deadline',
                'start_date' => '2025-01-15',
                'end_date' => '2025-01-15',
                'start_time' => '23:59',
                'end_time' => '23:59',
                'location' => 'Online',
                'color' => '#F59E0B',
                'academic_year_id' => $academicYear->id,
                'is_all_day' => false,
            ],
        ];

        foreach ($events as $event) {
            AcademicCalendar::create($event);
        }
    }
}

