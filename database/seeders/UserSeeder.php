<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1 Admin User
        $admin = \App\Models\User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@smpn01namrole.sch.id',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Pendidikan No. 1, Namrole',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // 5 Teacher Users
        $teachers = [
            [
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'budi.santoso@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'teacher',
                'phone' => '081234567891',
                'address' => 'Jl. Guru No. 1, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Siti Rahayu, S.Pd',
                'email' => 'siti.rahayu@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'teacher',
                'phone' => '081234567892',
                'address' => 'Jl. Guru No. 2, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ahmad Wijaya, S.Pd',
                'email' => 'ahmad.wijaya@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'teacher',
                'phone' => '081234567893',
                'address' => 'Jl. Guru No. 3, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Maria Magdalena, S.Pd',
                'email' => 'maria.magdalena@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'teacher',
                'phone' => '081234567894',
                'address' => 'Jl. Guru No. 4, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Joko Susilo, S.Pd',
                'email' => 'joko.susilo@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'teacher',
                'phone' => '081234567895',
                'address' => 'Jl. Guru No. 5, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        $teacherUsers = [];
        foreach ($teachers as $teacher) {
            $teacherUsers[] = \App\Models\User::create($teacher);
        }

        // 10 Student Users
        $students = [
            [
                'name' => 'Andi Pratama',
                'email' => 'andi.pratama@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'phone' => '081234567896',
                'address' => 'Jl. Siswa No. 1, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sari Indah',
                'email' => 'sari.indah@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'phone' => '081234567897',
                'address' => 'Jl. Siswa No. 2, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Rizki Ramadhan',
                'email' => 'rizki.ramadhan@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'phone' => '081234567898',
                'address' => 'Jl. Siswa No. 3, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Putri Sari',
                'email' => 'putri.sari@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'phone' => '081234567899',
                'address' => 'Jl. Siswa No. 4, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi.kurniawan@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'phone' => '081234567900',
                'address' => 'Jl. Siswa No. 5, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Lina Marlina',
                'email' => 'lina.marlina@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'phone' => '081234567901',
                'address' => 'Jl. Siswa No. 6, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar.nugroho@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'phone' => '081234567902',
                'address' => 'Jl. Siswa No. 7, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya.sari@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'phone' => '081234567903',
                'address' => 'Jl. Siswa No. 8, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Rudi Hartono',
                'email' => 'rudi.hartono@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'phone' => '081234567904',
                'address' => 'Jl. Siswa No. 9, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Nina Wulandari',
                'email' => 'nina.wulandari@smpn01namrole.sch.id',
                'password' => bcrypt('password123'),
                'role' => 'student',
                'phone' => '081234567905',
                'address' => 'Jl. Siswa No. 10, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        $studentUsers = [];
        foreach ($students as $student) {
            $studentUsers[] = \App\Models\User::create($student);
        }

        // 2 Parent Users
        $parents = [
            [
                'name' => 'Bapak Andi',
                'email' => 'bapak.andi@gmail.com',
                'password' => bcrypt('password123'),
                'role' => 'parent',
                'phone' => '081234567906',
                'address' => 'Jl. Orang Tua No. 1, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ibu Sari',
                'email' => 'ibu.sari@gmail.com',
                'password' => bcrypt('password123'),
                'role' => 'parent',
                'phone' => '081234567907',
                'address' => 'Jl. Orang Tua No. 2, Namrole',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        $parentUsers = [];
        foreach ($parents as $parent) {
            $parentUsers[] = \App\Models\User::create($parent);
        }

        // Create Teacher Profiles
        $teacherData = [
            ['nip' => '196512151990031001', 'subject' => 'Matematika', 'education' => 'S1 Matematika', 'join_date' => '1990-03-01'],
            ['nip' => '196803201990032002', 'subject' => 'Bahasa Indonesia', 'education' => 'S1 Bahasa Indonesia', 'join_date' => '1990-03-01'],
            ['nip' => '197005151990031003', 'subject' => 'IPA', 'education' => 'S1 Biologi', 'join_date' => '1990-03-01'],
            ['nip' => '197208201990032004', 'subject' => 'IPS', 'education' => 'S1 Sejarah', 'join_date' => '1990-03-01'],
            ['nip' => '197510251990031005', 'subject' => 'Bahasa Inggris', 'education' => 'S1 Bahasa Inggris', 'join_date' => '1990-03-01'],
        ];

        foreach ($teacherUsers as $index => $teacher) {
            \App\Models\Teacher::create([
                'user_id' => $teacher->id,
                'nip' => $teacherData[$index]['nip'],
                'subject' => $teacherData[$index]['subject'],
                'education' => $teacherData[$index]['education'],
                'join_date' => $teacherData[$index]['join_date'],
            ]);
        }

        // Create Student Profiles
        $studentData = [
            ['nis' => '2024001', 'nisn' => '0012345678', 'gender' => 'L', 'birth_place' => 'Namrole', 'birth_date' => '2009-01-15', 'parent_name' => 'Bapak Andi', 'parent_phone' => '081234567906'],
            ['nis' => '2024002', 'nisn' => '0012345679', 'gender' => 'P', 'birth_place' => 'Namrole', 'birth_date' => '2009-02-20', 'parent_name' => 'Ibu Sari', 'parent_phone' => '081234567907'],
            ['nis' => '2024003', 'nisn' => '0012345680', 'gender' => 'L', 'birth_place' => 'Namrole', 'birth_date' => '2009-03-10', 'parent_name' => 'Bapak Rudi', 'parent_phone' => '081234567908'],
            ['nis' => '2024004', 'nisn' => '0012345681', 'gender' => 'P', 'birth_place' => 'Namrole', 'birth_date' => '2009-04-05', 'parent_name' => 'Ibu Maya', 'parent_phone' => '081234567909'],
            ['nis' => '2024005', 'nisn' => '0012345682', 'gender' => 'L', 'birth_place' => 'Namrole', 'birth_date' => '2009-05-12', 'parent_name' => 'Bapak Dedi', 'parent_phone' => '081234567910'],
            ['nis' => '2024006', 'nisn' => '0012345683', 'gender' => 'P', 'birth_place' => 'Namrole', 'birth_date' => '2009-06-18', 'parent_name' => 'Ibu Lina', 'parent_phone' => '081234567911'],
            ['nis' => '2024007', 'nisn' => '0012345684', 'gender' => 'L', 'birth_place' => 'Namrole', 'birth_date' => '2009-07-25', 'parent_name' => 'Bapak Fajar', 'parent_phone' => '081234567912'],
            ['nis' => '2024008', 'nisn' => '0012345685', 'gender' => 'P', 'birth_place' => 'Namrole', 'birth_date' => '2009-08-30', 'parent_name' => 'Ibu Maya', 'parent_phone' => '081234567913'],
            ['nis' => '2024009', 'nisn' => '0012345686', 'gender' => 'L', 'birth_place' => 'Namrole', 'birth_date' => '2009-09-14', 'parent_name' => 'Bapak Rudi', 'parent_phone' => '081234567914'],
            ['nis' => '2024010', 'nisn' => '0012345687', 'gender' => 'P', 'birth_place' => 'Namrole', 'birth_date' => '2009-10-22', 'parent_name' => 'Ibu Nina', 'parent_phone' => '081234567915'],
        ];

        $academicYear = \App\Models\AcademicYear::where('is_active', true)->first();
        
        foreach ($studentUsers as $index => $student) {
            \App\Models\Profile::create([
                'user_id' => $student->id,
                'nis' => $studentData[$index]['nis'],
                'nisn' => $studentData[$index]['nisn'],
                'academic_year_id' => $academicYear->id,
                'gender' => $studentData[$index]['gender'],
                'birth_place' => $studentData[$index]['birth_place'],
                'birth_date' => $studentData[$index]['birth_date'],
                'parent_name' => $studentData[$index]['parent_name'],
                'parent_phone' => $studentData[$index]['parent_phone'],
            ]);
        }
    }
}
