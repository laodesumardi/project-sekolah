<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\TeacherClass;

class TeacherClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create academic year
        $academicYear = AcademicYear::firstOrCreate(
            ['name' => '2024/2025'],
            [
                'start_date' => '2024-07-01',
                'end_date' => '2025-06-30',
                'is_active' => true
            ]
        );

        // Get or create subjects
        $matematika = Subject::firstOrCreate(
            ['name' => 'Matematika'],
            [
                'code' => 'MAT',
                'description' => 'Mata pelajaran Matematika',
                'hours_per_week' => 4
            ]
        );
        
        $bahasaIndonesia = Subject::firstOrCreate(
            ['name' => 'Bahasa Indonesia'],
            [
                'code' => 'BIN',
                'description' => 'Mata pelajaran Bahasa Indonesia',
                'hours_per_week' => 3
            ]
        );
        
        $ipa = Subject::firstOrCreate(
            ['name' => 'IPA'],
            [
                'code' => 'IPA',
                'description' => 'Mata pelajaran Ilmu Pengetahuan Alam',
                'hours_per_week' => 3
            ]
        );

        // Get teacher
        $teacher = Teacher::first();
        if (!$teacher) {
            echo "No teacher found. Please run UserSeeder first.\n";
            return;
        }

        // Get or create classes (using the classes table, not school_classes)
        $class1 = \App\Models\SchoolClass::firstOrCreate(
            ['name' => 'VII A'],
            [
                'academic_year_id' => $academicYear->id
            ]
        );

        $class2 = \App\Models\SchoolClass::firstOrCreate(
            ['name' => 'VII B'],
            [
                'academic_year_id' => $academicYear->id
            ]
        );

        $class3 = \App\Models\SchoolClass::firstOrCreate(
            ['name' => 'VIII A'],
            [
                'academic_year_id' => $academicYear->id
            ]
        );

        // Create teacher-class assignments
        $assignments = [
            [
                'teacher_id' => $teacher->id,
                'class_id' => $class1->id,
                'subject_id' => $matematika->id,
                'academic_year_id' => $academicYear->id,
                'is_homeroom' => true
            ],
            [
                'teacher_id' => $teacher->id,
                'class_id' => $class1->id,
                'subject_id' => $bahasaIndonesia->id,
                'academic_year_id' => $academicYear->id,
                'is_homeroom' => false
            ],
            [
                'teacher_id' => $teacher->id,
                'class_id' => $class2->id,
                'subject_id' => $matematika->id,
                'academic_year_id' => $academicYear->id,
                'is_homeroom' => false
            ],
            [
                'teacher_id' => $teacher->id,
                'class_id' => $class2->id,
                'subject_id' => $ipa->id,
                'academic_year_id' => $academicYear->id,
                'is_homeroom' => false
            ],
            [
                'teacher_id' => $teacher->id,
                'class_id' => $class3->id,
                'subject_id' => $matematika->id,
                'academic_year_id' => $academicYear->id,
                'is_homeroom' => true
            ]
        ];

        foreach ($assignments as $assignment) {
            TeacherClass::firstOrCreate(
                [
                    'teacher_id' => $assignment['teacher_id'],
                    'class_id' => $assignment['class_id'],
                    'subject_id' => $assignment['subject_id'],
                    'academic_year_id' => $assignment['academic_year_id']
                ],
                $assignment
            );
        }

        echo "✅ Teacher class assignments created successfully!\n";
        echo "Teacher: {$teacher->user->name}\n";
        echo "Classes: VII A, VII B, VIII A\n";
        echo "Subjects: Matematika, Bahasa Indonesia, IPA\n";
    }
}
