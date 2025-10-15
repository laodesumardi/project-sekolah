<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\AcademicYear;
use App\Models\TeacherClass;
use Illuminate\Support\Facades\DB;

class SimpleClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get academic year
        $academicYear = AcademicYear::first();
        if (!$academicYear) {
            echo "No academic year found. Please run UserSeeder first.\n";
            return;
        }

        // Get teacher
        $teacher = Teacher::first();
        if (!$teacher) {
            echo "No teacher found. Please run UserSeeder first.\n";
            return;
        }

        // Get subjects
        $matematika = Subject::first();
        if (!$matematika) {
            echo "No subjects found. Please create subjects first.\n";
            return;
        }

        // Create classes directly in database
        $class1Id = DB::table('classes')->insertGetId([
            'name' => 'VII A',
            'grade_level' => 7,
            'academic_year_id' => $academicYear->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $class2Id = DB::table('classes')->insertGetId([
            'name' => 'VII B',
            'grade_level' => 7,
            'academic_year_id' => $academicYear->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $class3Id = DB::table('classes')->insertGetId([
            'name' => 'VIII A',
            'grade_level' => 8,
            'academic_year_id' => $academicYear->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create teacher-class assignments
        $assignments = [
            [
                'teacher_id' => $teacher->id,
                'class_id' => $class1Id,
                'subject_id' => $matematika->id,
                'academic_year_id' => $academicYear->id,
                'is_homeroom' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'teacher_id' => $teacher->id,
                'class_id' => $class2Id,
                'subject_id' => $matematika->id,
                'academic_year_id' => $academicYear->id,
                'is_homeroom' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'teacher_id' => $teacher->id,
                'class_id' => $class3Id,
                'subject_id' => $matematika->id,
                'academic_year_id' => $academicYear->id,
                'is_homeroom' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($assignments as $assignment) {
            DB::table('teacher_classes')->insert($assignment);
        }

        echo "✅ Teacher class assignments created successfully!\n";
        echo "Teacher: {$teacher->user->name}\n";
        echo "Classes: VII A, VII B, VIII A\n";
        echo "Subject: {$matematika->name}\n";
    }
}





