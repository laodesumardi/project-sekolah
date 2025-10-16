<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicYear;
use App\Models\AcademicCalendar;

class UpdateAcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update 2025/2026 to be active
        $academicYear = AcademicYear::where('name', '2025/2026')->first();
        if ($academicYear) {
            // Deactivate all years first
            AcademicYear::query()->update(['is_active' => false]);
            
            // Activate 2025/2026
            $academicYear->update(['is_active' => true]);
            
            $this->command->info('Activated academic year: ' . $academicYear->name);
        } else {
            // Create 2025/2026 if it doesn't exist
            $academicYear = AcademicYear::create([
                'name' => '2025/2026',
                'start_date' => '2025-07-01',
                'end_date' => '2026-06-30',
                'is_active' => true,
            ]);
            
            $this->command->info('Created and activated academic year: ' . $academicYear->name);
        }
        
        // Create events for 2025/2026
        $events = [
            [
                'title' => 'Awal Tahun Ajaran Baru 2025/2026',
                'description' => 'Hari pertama masuk sekolah untuk tahun ajaran baru 2025/2026',
                'event_type' => 'activity',
                'start_date' => '2025-07-15',
                'end_date' => '2025-07-15',
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
                'start_date' => '2025-09-16',
                'end_date' => '2025-09-23',
                'start_time' => null,
                'end_time' => null,
                'location' => 'Ruang Kelas',
                'color' => '#DC2626',
                'is_all_day' => true,
            ],
            [
                'title' => 'Ujian Akhir Semester Ganjil',
                'description' => 'Pelaksanaan ujian akhir semester untuk semester ganjil',
                'event_type' => 'exam',
                'start_date' => '2025-12-09',
                'end_date' => '2025-12-16',
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
                'start_date' => '2025-12-23',
                'end_date' => '2026-01-05',
                'start_time' => null,
                'end_time' => null,
                'location' => null,
                'color' => '#16A34A',
                'is_all_day' => true,
            ],
            [
                'title' => 'Awal Semester Genap',
                'description' => 'Hari pertama masuk sekolah untuk semester genap',
                'event_type' => 'activity',
                'start_date' => '2026-01-06',
                'end_date' => '2026-01-06',
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
                'start_date' => '2026-03-10',
                'end_date' => '2026-03-17',
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
                'start_date' => '2026-06-02',
                'end_date' => '2026-06-09',
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
                'start_date' => '2026-06-23',
                'end_date' => '2026-07-14',
                'start_time' => null,
                'end_time' => null,
                'location' => null,
                'color' => '#16A34A',
                'is_all_day' => true,
            ],
            [
                'title' => 'Perayaan HUT RI ke-80',
                'description' => 'Upacara dan kegiatan perayaan HUT RI ke-80',
                'event_type' => 'activity',
                'start_date' => '2025-08-17',
                'end_date' => '2025-08-17',
                'start_time' => '07:00',
                'end_time' => '12:00',
                'location' => 'Lapangan Upacara',
                'color' => '#2563EB',
                'is_all_day' => false,
            ],
            [
                'title' => 'Deadline Pengumpulan Raport Semester Ganjil',
                'description' => 'Batas akhir pengumpulan raport semester ganjil',
                'event_type' => 'deadline',
                'start_date' => '2025-12-20',
                'end_date' => '2025-12-20',
                'start_time' => null,
                'end_time' => null,
                'location' => 'Ruang Guru',
                'color' => '#F59E0B',
                'is_all_day' => true,
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler Oktober',
                'description' => 'Kegiatan ekstrakurikuler bulan Oktober',
                'event_type' => 'activity',
                'start_date' => '2025-10-15',
                'end_date' => '2025-10-15',
                'start_time' => '14:00',
                'end_time' => '16:00',
                'location' => 'Lapangan Sekolah',
                'color' => '#2563EB',
                'is_all_day' => false,
            ],
            [
                'title' => 'Workshop Guru',
                'description' => 'Workshop peningkatan kompetensi guru',
                'event_type' => 'activity',
                'start_date' => '2025-10-20',
                'end_date' => '2025-10-22',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'location' => 'Aula Sekolah',
                'color' => '#2563EB',
                'is_all_day' => false,
            ],
        ];

        foreach ($events as $event) {
            $event['academic_year_id'] = $academicYear->id;
            AcademicCalendar::create($event);
        }

        $this->command->info('Academic calendar events for 2025/2026 have been created successfully.');
    }
}

