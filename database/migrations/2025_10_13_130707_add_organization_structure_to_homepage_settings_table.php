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
            $table->string('organization_structure_title')->nullable()->after('about_page_facilities_description');
            $table->text('organization_structure_description')->nullable()->after('organization_structure_title');
            $table->string('organization_structure_image')->nullable()->after('organization_structure_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropColumn(['organization_structure_title', 'organization_structure_description', 'organization_structure_image']);
        });
    }
};