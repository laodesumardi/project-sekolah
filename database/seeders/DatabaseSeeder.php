<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AcademicYearSeeder::class,
            UserSeeder::class,
            NewsCategorySeeder::class,
            FacilityCategorySeeder::class,
            FacilitySeeder::class,
            // Academic Seeders
            SubjectSeeder::class,
            ExtracurricularSeeder::class,
            AcademicCalendarSeeder::class,
            AchievementSeeder::class,
        ]);
    }
}
