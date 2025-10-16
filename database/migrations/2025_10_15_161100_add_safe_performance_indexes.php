<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add safe indexes with column existence checks
        
        // Users table indexes
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'email') && !Schema::hasIndex('users', 'users_email_index')) {
                    $table->index('email');
                }
                if (Schema::hasColumn('users', 'created_at') && !Schema::hasIndex('users', 'users_created_at_index')) {
                    $table->index('created_at');
                }
                if (Schema::hasColumn('users', 'role') && Schema::hasColumn('users', 'created_at') && !Schema::hasIndex('users', 'users_role_created_at_index')) {
                    $table->index(['role', 'created_at']);
                }
            });
        }

        // News table additional indexes
        if (Schema::hasTable('news')) {
            Schema::table('news', function (Blueprint $table) {
                if (Schema::hasColumn('news', 'author_id') && !Schema::hasIndex('news', 'news_author_id_index')) {
                    $table->index('author_id');
                }
                if (Schema::hasColumn('news', 'created_at') && !Schema::hasIndex('news', 'news_created_at_index')) {
                    $table->index('created_at');
                }
                if (Schema::hasColumn('news', 'updated_at') && !Schema::hasIndex('news', 'news_updated_at_index')) {
                    $table->index('updated_at');
                }
                if (Schema::hasColumn('news', 'slug') && !Schema::hasIndex('news', 'news_slug_index')) {
                    $table->index('slug');
                }
            });
        }

        // Teachers table indexes
        if (Schema::hasTable('teachers')) {
            Schema::table('teachers', function (Blueprint $table) {
                if (Schema::hasColumn('teachers', 'user_id') && !Schema::hasIndex('teachers', 'teachers_user_id_index')) {
                    $table->index('user_id');
                }
                if (Schema::hasColumn('teachers', 'created_at') && !Schema::hasIndex('teachers', 'teachers_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // School classes table indexes
        if (Schema::hasTable('school_classes')) {
            Schema::table('school_classes', function (Blueprint $table) {
                if (Schema::hasColumn('school_classes', 'created_at') && !Schema::hasIndex('school_classes', 'school_classes_created_at_index')) {
                    $table->index('created_at');
                }
            });
        }

        // Registrations table indexes
        if (Schema::hasTable('registrations')) {
            Schema::table('registrations', function (Blueprint $table) {
                if (Schema::hasColumn('registrations', 'created_at') && !Schema::hasIndex('registrations', 'registrations_created_at_index')) {
                    $table->index('created_at');
                }
                if (Schema::hasColumn('registrations', 'email') && !Schema::hasIndex('registrations', 'registrations_email_index')) {
                    $table->index('email');
                }
                if (Schema::hasColumn('registrations', 'registration_number') && !Schema::hasIndex('registrations', 'registrations_registration_number_index')) {
                    $table->index('registration_number');
                }
            });
        }

        // News categories table indexes
        if (Schema::hasTable('news_categories')) {
            Schema::table('news_categories', function (Blueprint $table) {
                if (Schema::hasColumn('news_categories', 'name') && !Schema::hasIndex('news_categories', 'news_categories_name_index')) {
                    $table->index('name');
                }
                if (Schema::hasColumn('news_categories', 'slug') && !Schema::hasIndex('news_categories', 'news_categories_slug_index')) {
                    $table->index('slug');
                }
            });
        }

        // Tags table indexes
        if (Schema::hasTable('tags')) {
            Schema::table('tags', function (Blueprint $table) {
                if (Schema::hasColumn('tags', 'name') && !Schema::hasIndex('tags', 'tags_name_index')) {
                    $table->index('name');
                }
                if (Schema::hasColumn('tags', 'slug') && !Schema::hasIndex('tags', 'tags_slug_index')) {
                    $table->index('slug');
                }
            });
        }

        // Homepage settings table indexes
        if (Schema::hasTable('homepage_settings')) {
            Schema::table('homepage_settings', function (Blueprint $table) {
                if (Schema::hasColumn('homepage_settings', 'is_active') && !Schema::hasIndex('homepage_settings', 'homepage_settings_is_active_index')) {
                    $table->index('is_active');
                }
            });
        }

        // About page settings table indexes
        if (Schema::hasTable('about_page_settings')) {
            Schema::table('about_page_settings', function (Blueprint $table) {
                if (Schema::hasColumn('about_page_settings', 'is_active') && !Schema::hasIndex('about_page_settings', 'about_page_settings_is_active_index')) {
                    $table->index('is_active');
                }
            });
        }

        // Academic years table indexes
        if (Schema::hasTable('academic_years')) {
            Schema::table('academic_years', function (Blueprint $table) {
                if (Schema::hasColumn('academic_years', 'is_active') && !Schema::hasIndex('academic_years', 'academic_years_is_active_index')) {
                    $table->index('is_active');
                }
                if (Schema::hasColumn('academic_years', 'year') && !Schema::hasIndex('academic_years', 'academic_years_year_index')) {
                    $table->index('year');
                }
            });
        }

        // Registration settings table indexes
        if (Schema::hasTable('registration_settings')) {
            Schema::table('registration_settings', function (Blueprint $table) {
                if (Schema::hasColumn('registration_settings', 'is_active') && !Schema::hasIndex('registration_settings', 'registration_settings_is_active_index')) {
                    $table->index('is_active');
                }
            });
        }

        // Messages table indexes
        if (Schema::hasTable('messages')) {
            Schema::table('messages', function (Blueprint $table) {
                if (Schema::hasColumn('messages', 'created_at') && !Schema::hasIndex('messages', 'messages_created_at_index')) {
                    $table->index('created_at');
                }
                if (Schema::hasColumn('messages', 'email') && !Schema::hasIndex('messages', 'messages_email_index')) {
                    $table->index('email');
                }
                if (Schema::hasColumn('messages', 'is_read') && !Schema::hasIndex('messages', 'messages_is_read_index')) {
                    $table->index('is_read');
                }
            });
        }

        // Gallery images table indexes
        if (Schema::hasTable('gallery_images')) {
            Schema::table('gallery_images', function (Blueprint $table) {
                if (Schema::hasColumn('gallery_images', 'gallery_id') && !Schema::hasIndex('gallery_images', 'gallery_images_gallery_id_index')) {
                    $table->index('gallery_id');
                }
                if (Schema::hasColumn('gallery_images', 'sort_order') && !Schema::hasIndex('gallery_images', 'gallery_images_sort_order_index')) {
                    $table->index('sort_order');
                }
                if (Schema::hasColumn('gallery_images', 'is_cover') && !Schema::hasIndex('gallery_images', 'gallery_images_is_cover_index')) {
                    $table->index('is_cover');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes safely
        $this->removeIndexIfExists('users', 'users_email_index');
        $this->removeIndexIfExists('users', 'users_created_at_index');
        $this->removeIndexIfExists('users', 'users_role_created_at_index');
        
        $this->removeIndexIfExists('news', 'news_author_id_index');
        $this->removeIndexIfExists('news', 'news_created_at_index');
        $this->removeIndexIfExists('news', 'news_updated_at_index');
        $this->removeIndexIfExists('news', 'news_slug_index');
        
        $this->removeIndexIfExists('teachers', 'teachers_user_id_index');
        $this->removeIndexIfExists('teachers', 'teachers_created_at_index');
        
        $this->removeIndexIfExists('school_classes', 'school_classes_created_at_index');
        
        $this->removeIndexIfExists('registrations', 'registrations_created_at_index');
        $this->removeIndexIfExists('registrations', 'registrations_email_index');
        $this->removeIndexIfExists('registrations', 'registrations_registration_number_index');
        
        $this->removeIndexIfExists('news_categories', 'news_categories_name_index');
        $this->removeIndexIfExists('news_categories', 'news_categories_slug_index');
        
        $this->removeIndexIfExists('tags', 'tags_name_index');
        $this->removeIndexIfExists('tags', 'tags_slug_index');
        
        $this->removeIndexIfExists('homepage_settings', 'homepage_settings_is_active_index');
        $this->removeIndexIfExists('about_page_settings', 'about_page_settings_is_active_index');
        $this->removeIndexIfExists('academic_years', 'academic_years_is_active_index');
        $this->removeIndexIfExists('academic_years', 'academic_years_year_index');
        $this->removeIndexIfExists('registration_settings', 'registration_settings_is_active_index');
        
        $this->removeIndexIfExists('messages', 'messages_created_at_index');
        $this->removeIndexIfExists('messages', 'messages_email_index');
        $this->removeIndexIfExists('messages', 'messages_is_read_index');
        
        $this->removeIndexIfExists('gallery_images', 'gallery_images_gallery_id_index');
        $this->removeIndexIfExists('gallery_images', 'gallery_images_sort_order_index');
        $this->removeIndexIfExists('gallery_images', 'gallery_images_is_cover_index');
    }

    /**
     * Remove index if it exists
     */
    private function removeIndexIfExists($table, $index)
    {
        if (Schema::hasTable($table) && Schema::hasIndex($table, $index)) {
            Schema::table($table, function (Blueprint $table) use ($index) {
                $table->dropIndex([$index]);
            });
        }
    }
};


