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
        Schema::table('homepage_settings', function (Blueprint $table) {
            // Add missing background image columns if they don't exist
            if (!Schema::hasColumn('homepage_settings', 'hero_background_image')) {
                $table->string('hero_background_image')->nullable();
            }
            if (!Schema::hasColumn('homepage_settings', 'about_page_background_image')) {
                $table->string('about_page_background_image')->nullable();
            }
            if (!Schema::hasColumn('homepage_settings', 'curriculum_page_background_image')) {
                $table->string('curriculum_page_background_image')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropColumn(['hero_background_image', 'about_page_background_image', 'curriculum_page_background_image']);
        });
    }
};
