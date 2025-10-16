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
        // Add comprehensive indexes for better performance
        
        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasIndex('users', 'users_email_index')) {
                $table->index('email');
            }
            if (!Schema::hasIndex('users', 'users_created_at_index')) {
                $table->index('created_at');
            }
            if (!Schema::hasIndex('users', 'users_role_created_at_index')) {
                $table->index(['role', 'created_at']);
            }
        });

        // News table additional indexes
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasIndex('news', 'news_author_id_index')) {
                $table->index('author_id');
            }
            if (!Schema::hasIndex('news', 'news_created_at_index')) {
                $table->index('created_at');
            }
            if (!Schema::hasIndex('news', 'news_updated_at_index')) {
                $table->index('updated_at');
            }
            if (!Schema::hasIndex('news', 'news_slug_index')) {
                $table->index('slug');
            }
        });

        // Teachers table indexes
        Schema::table('teachers', function (Blueprint $table) {
            if (!Schema::hasIndex('teachers', 'teachers_user_id_index')) {
                $table->index('user_id');
            }
            if (!Schema::hasIndex('teachers', 'teachers_created_at_index')) {
                $table->index('created_at');
            }
        });

        // School classes table indexes
        Schema::table('school_classes', function (Blueprint $table) {
            if (!Schema::hasIndex('school_classes', 'school_classes_grade_level_index')) {
                $table->index('grade_level');
            }
            if (!Schema::hasIndex('school_classes', 'school_classes_created_at_index')) {
                $table->index('created_at');
            }
        });

        // Registrations table indexes
        Schema::table('registrations', function (Blueprint $table) {
            if (!Schema::hasIndex('registrations', 'registrations_created_at_index')) {
                $table->index('created_at');
            }
            if (!Schema::hasIndex('registrations', 'registrations_email_index')) {
                $table->index('email');
            }
            if (!Schema::hasIndex('registrations', 'registrations_registration_number_index')) {
                $table->index('registration_number');
            }
        });

        // News categories table indexes
        Schema::table('news_categories', function (Blueprint $table) {
            if (!Schema::hasIndex('news_categories', 'news_categories_name_index')) {
                $table->index('name');
            }
            if (!Schema::hasIndex('news_categories', 'news_categories_slug_index')) {
                $table->index('slug');
            }
        });

        // Tags table indexes
        Schema::table('tags', function (Blueprint $table) {
            if (!Schema::hasIndex('tags', 'tags_name_index')) {
                $table->index('name');
            }
            if (!Schema::hasIndex('tags', 'tags_slug_index')) {
                $table->index('slug');
            }
        });

        // Homepage settings table indexes
        Schema::table('homepage_settings', function (Blueprint $table) {
            if (!Schema::hasIndex('homepage_settings', 'homepage_settings_is_active_index')) {
                $table->index('is_active');
            }
        });

        // About page settings table indexes
        Schema::table('about_page_settings', function (Blueprint $table) {
            if (!Schema::hasIndex('about_page_settings', 'about_page_settings_is_active_index')) {
                $table->index('is_active');
            }
        });

        // Academic years table indexes
        Schema::table('academic_years', function (Blueprint $table) {
            if (!Schema::hasIndex('academic_years', 'academic_years_is_active_index')) {
                $table->index('is_active');
            }
            if (!Schema::hasIndex('academic_years', 'academic_years_year_index')) {
                $table->index('year');
            }
        });

        // Registration settings table indexes
        Schema::table('registration_settings', function (Blueprint $table) {
            if (!Schema::hasIndex('registration_settings', 'registration_settings_is_active_index')) {
                $table->index('is_active');
            }
        });

        // Messages table indexes
        Schema::table('messages', function (Blueprint $table) {
            if (!Schema::hasIndex('messages', 'messages_created_at_index')) {
                $table->index('created_at');
            }
            if (!Schema::hasIndex('messages', 'messages_email_index')) {
                $table->index('email');
            }
            if (!Schema::hasIndex('messages', 'messages_is_read_index')) {
                $table->index('is_read');
            }
        });

        // Gallery images table indexes
        Schema::table('gallery_images', function (Blueprint $table) {
            if (!Schema::hasIndex('gallery_images', 'gallery_images_gallery_id_index')) {
                $table->index('gallery_id');
            }
            if (!Schema::hasIndex('gallery_images', 'gallery_images_sort_order_index')) {
                $table->index('sort_order');
            }
            if (!Schema::hasIndex('gallery_images', 'gallery_images_is_cover_index')) {
                $table->index('is_cover');
            }
        });

        // Extracurricular registrations table indexes
        Schema::table('extracurricular_registrations', function (Blueprint $table) {
            if (!Schema::hasIndex('extracurricular_registrations', 'extracurricular_registrations_extracurricular_id_index')) {
                $table->index('extracurricular_id');
            }
            if (!Schema::hasIndex('extracurricular_registrations', 'extracurricular_registrations_user_id_index')) {
                $table->index('user_id');
            }
            if (!Schema::hasIndex('extracurricular_registrations', 'extracurricular_registrations_created_at_index')) {
                $table->index('created_at');
            }
        });

        // Assignments table indexes
        Schema::table('assignments', function (Blueprint $table) {
            if (!Schema::hasIndex('assignments', 'assignments_teacher_id_index')) {
                $table->index('teacher_id');
            }
            if (!Schema::hasIndex('assignments', 'assignments_class_id_index')) {
                $table->index('class_id');
            }
            if (!Schema::hasIndex('assignments', 'assignments_subject_id_index')) {
                $table->index('subject_id');
            }
            if (!Schema::hasIndex('assignments', 'assignments_due_date_index')) {
                $table->index('due_date');
            }
            if (!Schema::hasIndex('assignments', 'assignments_is_published_index')) {
                $table->index('is_published');
            }
        });

        // Assignment submissions table indexes
        Schema::table('assignment_submissions', function (Blueprint $table) {
            if (!Schema::hasIndex('assignment_submissions', 'assignment_submissions_assignment_id_index')) {
                $table->index('assignment_id');
            }
            if (!Schema::hasIndex('assignment_submissions', 'assignment_submissions_student_id_index')) {
                $table->index('student_id');
            }
            if (!Schema::hasIndex('assignment_submissions', 'assignment_submissions_submitted_at_index')) {
                $table->index('submitted_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes for users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['role', 'created_at']);
        });

        // Remove indexes for news table
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['author_id']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['updated_at']);
            $table->dropIndex(['slug']);
        });

        // Remove indexes for teachers table
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        // Remove indexes for school_classes table
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropIndex(['grade_level']);
            $table->dropIndex(['created_at']);
        });

        // Remove indexes for registrations table
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['email']);
            $table->dropIndex(['registration_number']);
        });

        // Remove indexes for news_categories table
        Schema::table('news_categories', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['slug']);
        });

        // Remove indexes for tags table
        Schema::table('tags', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['slug']);
        });

        // Remove indexes for homepage_settings table
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        // Remove indexes for about_page_settings table
        Schema::table('about_page_settings', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        // Remove indexes for academic_years table
        Schema::table('academic_years', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['year']);
        });

        // Remove indexes for registration_settings table
        Schema::table('registration_settings', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        // Remove indexes for messages table
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['email']);
            $table->dropIndex(['is_read']);
        });

        // Remove indexes for gallery_images table
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->dropIndex(['gallery_id']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['is_cover']);
        });

        // Remove indexes for extracurricular_registrations table
        Schema::table('extracurricular_registrations', function (Blueprint $table) {
            $table->dropIndex(['extracurricular_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        // Remove indexes for assignments table
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropIndex(['teacher_id']);
            $table->dropIndex(['class_id']);
            $table->dropIndex(['subject_id']);
            $table->dropIndex(['due_date']);
            $table->dropIndex(['is_published']);
        });

        // Remove indexes for assignment_submissions table
        Schema::table('assignment_submissions', function (Blueprint $table) {
            $table->dropIndex(['assignment_id']);
            $table->dropIndex(['student_id']);
            $table->dropIndex(['submitted_at']);
        });
    }
};

