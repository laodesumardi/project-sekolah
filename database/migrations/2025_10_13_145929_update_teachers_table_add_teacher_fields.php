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
        Schema::table('teachers', function (Blueprint $table) {
            // Add new columns that don't exist yet
            $table->string('nik')->nullable()->after('nip');
            $table->string('birth_place')->nullable()->after('nik');
            $table->date('birth_date')->nullable()->after('birth_place');
            $table->enum('gender', ['L', 'P'])->nullable()->after('birth_date');
            $table->string('religion')->nullable()->after('gender');
            $table->text('address')->nullable()->after('religion');
            $table->string('phone')->nullable()->after('address');
            $table->enum('employment_status', ['PNS', 'Honorer', 'GTT', 'GTY'])->default('PNS')->after('phone');
            $table->enum('education_level', ['S1', 'S2', 'S3'])->nullable()->after('employment_status');
            $table->string('major')->nullable()->after('education_level');
            $table->string('university')->nullable()->after('major');
            $table->integer('graduation_year')->nullable()->after('university');
            $table->string('certification_number')->nullable()->after('graduation_year');
            $table->string('cv_path')->nullable()->after('certification_number');
            $table->text('bio')->nullable()->after('cv_path');
            $table->boolean('is_active')->default(true)->after('bio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'birth_place',
                'birth_date',
                'gender',
                'religion',
                'address',
                'phone',
                'employment_status',
                'education_level',
                'major',
                'university',
                'graduation_year',
                'certification_number',
                'cv_path',
                'bio',
                'is_active',
            ]);
        });
    }
};