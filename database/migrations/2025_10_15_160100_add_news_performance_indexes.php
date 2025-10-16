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
        // Add indexes for news table for better performance
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasIndex('news', 'news_published_at_index')) {
                $table->index('published_at');
            }
            if (!Schema::hasIndex('news', 'news_category_id_index')) {
                $table->index('category_id');
            }
            if (!Schema::hasIndex('news', 'news_is_featured_index')) {
                $table->index('is_featured');
            }
            if (!Schema::hasIndex('news', 'news_views_index')) {
                $table->index('views');
            }
        });

        // Add indexes for achievements table
        Schema::table('achievements', function (Blueprint $table) {
            if (!Schema::hasIndex('achievements', 'achievements_is_published_index')) {
                $table->index('is_published');
            }
            if (!Schema::hasIndex('achievements', 'achievements_achievement_level_index')) {
                $table->index('achievement_level');
            }
            if (!Schema::hasIndex('achievements', 'achievements_category_index')) {
                $table->index('category');
            }
        });

        // Add indexes for galleries table
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasIndex('galleries', 'galleries_is_published_index')) {
                $table->index('is_published');
            }
            if (!Schema::hasIndex('galleries', 'galleries_is_featured_index')) {
                $table->index('is_featured');
            }
            if (!Schema::hasIndex('galleries', 'galleries_category_index')) {
                $table->index('category');
            }
        });

        // Add indexes for facilities table
        Schema::table('facilities', function (Blueprint $table) {
            if (!Schema::hasIndex('facilities', 'facilities_is_available_index')) {
                $table->index('is_available');
            }
            if (!Schema::hasIndex('facilities', 'facilities_category_index')) {
                $table->index('category');
            }
        });

        // Add indexes for extracurriculars table
        Schema::table('extracurriculars', function (Blueprint $table) {
            if (!Schema::hasIndex('extracurriculars', 'extracurriculars_is_active_index')) {
                $table->index('is_active');
            }
            if (!Schema::hasIndex('extracurriculars', 'extracurriculars_category_index')) {
                $table->index('category');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove indexes for news table
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['published_at']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['views']);
        });

        // Remove indexes for achievements table
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropIndex(['is_published']);
            $table->dropIndex(['achievement_level']);
            $table->dropIndex(['category']);
        });

        // Remove indexes for galleries table
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex(['is_published']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['category']);
        });

        // Remove indexes for facilities table
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropIndex(['is_available']);
            $table->dropIndex(['category']);
        });

        // Remove indexes for extracurriculars table
        Schema::table('extracurriculars', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['category']);
        });
    }
};




