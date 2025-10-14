<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // General settings
            $table->string('language', 5)->default('id')->after('two_factor_secret');
            $table->string('timezone', 50)->default('Asia/Jakarta')->after('language');
            $table->string('date_format', 10)->default('d/m/Y')->after('timezone');
            $table->string('time_format', 2)->default('24')->after('date_format');
            $table->string('theme', 10)->default('light')->after('time_format');
            
            // Notification settings
            $table->boolean('email_notifications')->default(true)->after('theme');
            $table->boolean('sms_notifications')->default(false)->after('email_notifications');
            $table->boolean('push_notifications')->default(true)->after('sms_notifications');
            $table->boolean('assignment_reminders')->default(true)->after('push_notifications');
            $table->boolean('grade_notifications')->default(true)->after('assignment_reminders');
            $table->boolean('announcement_notifications')->default(true)->after('grade_notifications');
            
            // Privacy settings
            $table->boolean('show_attendance_to_parents')->default(true)->after('allow_parent_access');
            $table->boolean('show_grades_to_parents')->default(true)->after('show_attendance_to_parents');
            
            // Account settings
            $table->boolean('auto_logout')->default(false)->after('show_grades_to_parents');
            $table->integer('session_timeout')->default(30)->after('auto_logout');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'language', 'timezone', 'date_format', 'time_format', 'theme',
                'email_notifications', 'sms_notifications', 'push_notifications',
                'assignment_reminders', 'grade_notifications', 'announcement_notifications',
                'show_attendance_to_parents', 'show_grades_to_parents',
                'auto_logout', 'session_timeout'
            ]);
        });
    }
};
