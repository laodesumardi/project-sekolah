<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegistrationSetting;
use Carbon\Carbon;

class UpdateRegistrationDatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all active registration settings to start today
        $today = Carbon::today();
        $endDate = $today->copy()->addDays(30); // 30 days from today
        $announcementDate = $endDate->copy()->addDays(7); // 7 days after registration ends

        RegistrationSetting::where('is_active', true)->update([
            'start_date' => $today,
            'end_date' => $endDate,
            'announcement_date' => $announcementDate,
        ]);

        $this->command->info('Registration dates updated:');
        $this->command->info('Start Date: ' . $today->format('Y-m-d'));
        $this->command->info('End Date: ' . $endDate->format('Y-m-d'));
        $this->command->info('Announcement Date: ' . $announcementDate->format('Y-m-d'));
    }
}