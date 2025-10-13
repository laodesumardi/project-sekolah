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
            $table->string('library_operational_hours_weekdays')->nullable()->after('library_structure_image');
            $table->string('library_operational_hours_saturday')->nullable()->after('library_operational_hours_weekdays');
            $table->string('library_location')->nullable()->after('library_operational_hours_saturday');
            $table->string('library_email')->nullable()->after('library_location');
            $table->string('library_phone')->nullable()->after('library_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropColumn([
                'library_operational_hours_weekdays',
                'library_operational_hours_saturday', 
                'library_location',
                'library_email',
                'library_phone'
            ]);
        });
    }
};