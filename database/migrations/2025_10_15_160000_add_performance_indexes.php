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
        // Add indexes for users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasIndex('users', 'users_role_index')) {
                $table->index('role');
            }
            if (!Schema::hasIndex('users', 'users_role_created_at_index')) {
                $table->index(['role', 'created_at']);
            }
        });

        // Add indexes for achievements table
        Schema::table('achievements', function (Blueprint $table) {
            $table->index(['is_published', 'achievement_level']);
            $table->index(['is_published', 'category']);
            $table->index(['is_published', 'created_at']);
        });

        // Add indexes for news table
        Schema::table('news', function (Blueprint $table) {
            $table->index(['published_at', 'is_featured']);
            $table->index(['category_id', 'published_at']);
            $table->index(['is_featured', 'published_at']);
        });

        // Add indexes for galleries table
        Schema::table('galleries', function (Blueprint $table) {
            $table->index(['is_published', 'is_featured']);
            $table->index(['category', 'is_published']);
            $table->index(['date', 'is_published']);
        });

        // Add indexes for facilities table
        Schema::table('facilities', function (Blueprint $table) {
            $table->index(['is_available', 'category']);
            $table->index(['sort_order', 'is_available']);
        });

        // Add indexes for extracurriculars table
        Schema::table('extracurriculars', function (Blueprint $table) {
            $table->index(['is_active', 'is_featured']);
            $table->index(['category', 'is_active']);
            $table->index(['schedule_day', 'is_active']);
        });

        // Add indexes for registrations table
        Schema::table('registrations', function (Blueprint $table) {
            $table->index(['academic_year_id', 'status']);
            $table->index(['status', 'created_at']);
            $table->index(['registration_path', 'status']);
        });

        // Add indexes for teachers table
        Schema::table('teachers', function (Blueprint $table) {
            $table->index(['is_active', 'created_at']);
        });

        // Add indexes for school_classes table
        Schema::table('school_classes', function (Blueprint $table) {
            $table->index(['is_active', 'grade_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes for users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['role', 'created_at']);
        });

        // Remove indexes for achievements table
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'achievement_level']);
            $table->dropIndex(['is_published', 'category']);
            $table->dropIndex(['is_published', 'created_at']);
        });

        // Remove indexes for news table
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['published_at', 'is_published']);
            $table->dropIndex(['category_id', 'is_published']);
            $table->dropIndex(['is_published', 'featured']);
        });

        // Remove indexes for galleries table
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'is_featured']);
            $table->dropIndex(['category', 'is_published']);
            $table->dropIndex(['date', 'is_published']);
        });

        // Remove indexes for facilities table
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropIndex(['is_available', 'category']);
            $table->dropIndex(['sort_order', 'is_available']);
        });

        // Remove indexes for extracurriculars table
        Schema::table('extracurriculars', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'is_featured']);
            $table->dropIndex(['category', 'is_active']);
            $table->dropIndex(['schedule_day', 'is_active']);
        });

        // Remove indexes for registrations table
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropIndex(['academic_year_id', 'status']);
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['registration_path', 'status']);
        });

        // Remove indexes for teachers table
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'created_at']);
        });

        // Remove indexes for school_classes table
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'grade_level']);
        });
    }
};
