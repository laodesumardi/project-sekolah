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
            $table->string('about_page_title')->nullable()->after('accreditation_certificate');
            $table->text('about_page_description')->nullable()->after('about_page_title');
            $table->text('about_page_mission')->nullable()->after('about_page_description');
            $table->text('about_page_vision')->nullable()->after('about_page_mission');
            $table->text('about_page_history')->nullable()->after('about_page_vision');
            $table->string('about_page_principal_name')->nullable()->after('about_page_history');
            $table->string('about_page_principal_title')->nullable()->after('about_page_principal_name');
            $table->text('about_page_principal_message')->nullable()->after('about_page_principal_title');
            $table->string('about_page_principal_photo')->nullable()->after('about_page_principal_message');
            $table->string('about_page_school_photo')->nullable()->after('about_page_principal_photo');
            $table->string('about_page_organization_chart')->nullable()->after('about_page_school_photo');
            $table->text('about_page_achievements')->nullable()->after('about_page_organization_chart');
            $table->text('about_page_facilities_description')->nullable()->after('about_page_achievements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropColumn([
                'about_page_title', 'about_page_description', 'about_page_mission', 'about_page_vision', 'about_page_history',
                'about_page_principal_name', 'about_page_principal_title', 'about_page_principal_message', 'about_page_principal_photo',
                'about_page_school_photo', 'about_page_organization_chart', 'about_page_achievements', 'about_page_facilities_description'
            ]);
        });
    }
};
