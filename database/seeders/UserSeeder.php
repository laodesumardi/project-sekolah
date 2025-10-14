<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\AcademicYear;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Academic Year first
        $academicYear = AcademicYear::firstOrCreate([
            'name' => '2024/2025',
            'start_date' => '2024-07-01',
            'end_date' => '2025-06-30',
            'is_active' => true,
        ]);

        // Create School Class
        $schoolClass = SchoolClass::firstOrCreate([
            'name' => 'Kelas 7A',
            'academic_year_id' => $academicYear->id,
        ]);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        echo "✅ Admin user: admin@sekolah.sch.id / password\n";

        // Create Teacher User
        $teacher = User::firstOrCreate(
            ['email' => 'guru@sekolah.sch.id'],
            [
                'name' => 'Guru Matematika',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]
        );

        // Create Teacher Profile
        $teacherProfile = Teacher::firstOrCreate(
            ['user_id' => $teacher->id],
            [
                'nip' => '196001011990031001',
                'nik' => '196001011990031001',
                'birth_place' => 'Jakarta',
                'birth_date' => '1960-01-01',
                'gender' => 'L',
                'religion' => 'Islam',
                'address' => 'Jl. Pendidikan No. 123, Jakarta',
                'phone' => '081234567890',
                'employment_status' => 'PNS',
                'join_date' => '1990-01-01',
                'education_level' => 'S1',
                'major' => 'Matematika',
                'university' => 'Universitas Indonesia',
                'graduation_year' => 1985,
                'certification_number' => '1234567890',
                'bio' => 'Guru matematika berpengalaman dengan passion mengajar yang tinggi.',
                'is_active' => true,
                'subject' => 'Matematika',
                'education' => 'S1 Matematika',
            ]
        );

        echo "✅ Teacher user: guru@sekolah.sch.id / password\n";

        // Create Student User
        $student = User::firstOrCreate(
            ['email' => 'siswa@sekolah.sch.id'],
            [
                'name' => 'Siswa Kelas 7A',
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]
        );

        // Create Student Profile
        $studentProfile = Profile::firstOrCreate(
            ['user_id' => $student->id],
            [
                'nis' => '2024001',
                'nisn' => '1234567890',
                'class_id' => $schoolClass->id,
                'academic_year_id' => $academicYear->id,
                'gender' => 'L',
                'birth_place' => 'Jakarta',
                'birth_date' => '2010-01-01',
                'parent_name' => 'Orang Tua Siswa',
                'parent_phone' => '081234567890',
                'phone' => '081234567891',
                'address' => 'Jl. Siswa No. 456, Jakarta',
            ]
        );

        echo "✅ Student user: siswa@sekolah.sch.id / password\n";

        // Create additional test users
        $this->createAdditionalUsers($academicYear, $schoolClass);
    }

    private function createAdditionalUsers($academicYear, $schoolClass)
    {
        // Additional Teacher
        $teacher2 = User::create([
            'name' => 'Guru Bahasa Indonesia',
            'email' => 'guru2@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);

        Teacher::firstOrCreate(
            ['user_id' => $teacher2->id],
            [
                'nip' => '196501011990031002',
                'nik' => '196501011990031002',
                'birth_place' => 'Bandung',
                'birth_date' => '1965-01-01',
                'gender' => 'P',
                'religion' => 'Islam',
                'address' => 'Jl. Pendidikan No. 456, Bandung',
                'phone' => '081234567891',
                'employment_status' => 'PNS',
                'join_date' => '1990-01-01',
                'education_level' => 'S1',
                'major' => 'Bahasa Indonesia',
                'university' => 'Universitas Padjadjaran',
                'graduation_year' => 1987,
                'certification_number' => '1234567891',
                'bio' => 'Guru bahasa Indonesia yang kreatif dan inovatif.',
                'is_active' => true,
                'subject' => 'Bahasa Indonesia',
                'education' => 'S1 Bahasa Indonesia',
            ]
        );

        echo "✅ Additional teacher created: guru2@sekolah.sch.id / password\n";

        // Additional Student
        $student2 = User::create([
            'name' => 'Siswa Kelas 7B',
            'email' => 'siswa2@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $student2->id,
            'nis' => '2024002',
            'nisn' => '1234567891',
            'class_id' => $schoolClass->id,
            'academic_year_id' => $academicYear->id,
            'gender' => 'P',
            'birth_place' => 'Surabaya',
            'birth_date' => '2010-05-15',
            'parent_name' => 'Orang Tua Siswa 2',
            'parent_phone' => '081234567892',
            'phone' => '081234567893',
            'address' => 'Jl. Siswa No. 789, Surabaya',
        ]);

        echo "✅ Additional student created: siswa2@sekolah.sch.id / password\n";
    }
}