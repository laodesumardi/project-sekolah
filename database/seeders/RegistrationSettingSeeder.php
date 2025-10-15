<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegistrationSetting;
use App\Models\AcademicYear;

class RegistrationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = AcademicYear::where('is_active', true)->first();
        
        if (!$currentYear) {
            $this->command->warn('Tidak ada tahun ajaran aktif. Membuat tahun ajaran baru...');
            $currentYear = AcademicYear::create([
                'year' => '2025/2026',
                'start_date' => '2025-07-01',
                'end_date' => '2026-06-30',
                'is_active' => true,
            ]);
        }

        RegistrationSetting::create([
            'academic_year_id' => $currentYear->id,
            'start_date' => now()->subDays(1), // Mulai kemarin (sudah dibuka)
            'end_date' => now()->addDays(30), // Berakhir 30 hari dari sekarang
            'announcement_date' => now()->addDays(32), // Pengumuman 2 hari setelah tutup (setelah end_date)
            'quota_regular' => 200,
            'quota_achievement' => 50,
            'quota_affirmation' => 30,
            'registration_fee' => 150000,
            'is_active' => true,
            'is_open' => true,
            'information' => '<h3>Informasi PPDB Tahun Ajaran ' . $currentYear->year . '</h3>
            <p>Pendaftaran PPDB SMP Negeri 01 Namrole telah dibuka. Silakan ikuti langkah-langkah pendaftaran dengan benar.</p>
            <h4>Persyaratan Umum:</h4>
            <ul>
                <li>Usia maksimal 15 tahun pada 1 Juli 2025</li>
                <li>Lulus dari SD/MI atau sederajat</li>
                <li>Memiliki NIK dan NISN yang valid</li>
                <li>Sehat jasmani dan rohani</li>
            </ul>
            <h4>Jalur Pendaftaran:</h4>
            <ul>
                <li><strong>Jalur Prestasi:</strong> Untuk siswa berprestasi akademik/non-akademik</li>
                <li><strong>Jalur Reguler:</strong> Jalur umum untuk semua calon siswa</li>
                <li><strong>Jalur Afirmasi:</strong> Khusus siswa dari keluarga kurang mampu</li>
            </ul>
            <h4>Dokumen yang Diperlukan:</h4>
            <ul>
                <li>Foto siswa 3x4 (latar belakang merah)</li>
                <li>Scan ijazah/SKHUN SD/MI</li>
                <li>Scan kartu keluarga</li>
                <li>Scan akta kelahiran</li>
                <li>Sertifikat prestasi (jika ada)</li>
            </ul>',
        ]);
    }
}

