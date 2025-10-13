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
            $table->string('accreditation_grade')->nullable()->after('principal_photo');
            $table->text('accreditation_description')->nullable()->after('accreditation_grade');
            $table->string('accreditation_valid_until')->nullable()->after('accreditation_description');
            $table->string('accreditation_certificate')->nullable()->after('accreditation_valid_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropColumn(['accreditation_grade', 'accreditation_description', 'accreditation_valid_until', 'accreditation_certificate']);
        });
    }
};
