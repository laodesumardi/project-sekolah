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
        Schema::table('registrations', function (Blueprint $table) {
            // Make fields nullable that are not used in simplified form
            $table->integer('child_number')->nullable()->change();
            $table->integer('siblings_count')->nullable()->change();
            $table->string('rt', 3)->nullable()->change();
            $table->string('rw', 3)->nullable()->change();
            $table->string('kelurahan')->nullable()->change();
            $table->string('kecamatan')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('province')->nullable()->change();
            $table->string('postal_code', 5)->nullable()->change();
            $table->string('father_nik', 16)->nullable()->change();
            $table->integer('father_birth_year')->nullable()->change();
            $table->string('father_education')->nullable()->change();
            $table->string('father_income')->nullable()->change();
            $table->string('father_phone', 15)->nullable()->change();
            $table->string('mother_nik', 16)->nullable()->change();
            $table->integer('mother_birth_year')->nullable()->change();
            $table->string('mother_education')->nullable()->change();
            $table->string('mother_income')->nullable()->change();
            $table->string('mother_phone', 15)->nullable()->change();
            $table->string('previous_school')->nullable()->change();
            $table->string('school_npsn', 8)->nullable()->change();
            $table->text('school_address')->nullable()->change();
            $table->integer('graduation_year')->nullable()->change();
            $table->string('certificate_number')->nullable()->change();
            $table->decimal('average_score', 5, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Revert nullable changes
            $table->integer('child_number')->nullable(false)->change();
            $table->integer('siblings_count')->nullable(false)->change();
            $table->string('rt', 3)->nullable(false)->change();
            $table->string('rw', 3)->nullable(false)->change();
            $table->string('kelurahan')->nullable(false)->change();
            $table->string('kecamatan')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('province')->nullable(false)->change();
            $table->string('postal_code', 5)->nullable(false)->change();
            $table->string('father_nik', 16)->nullable(false)->change();
            $table->integer('father_birth_year')->nullable(false)->change();
            $table->string('father_education')->nullable(false)->change();
            $table->string('father_income')->nullable(false)->change();
            $table->string('father_phone', 15)->nullable(false)->change();
            $table->string('mother_nik', 16)->nullable(false)->change();
            $table->integer('mother_birth_year')->nullable(false)->change();
            $table->string('mother_education')->nullable(false)->change();
            $table->string('mother_income')->nullable(false)->change();
            $table->string('mother_phone', 15)->nullable(false)->change();
            $table->string('previous_school')->nullable(false)->change();
            $table->string('school_npsn', 8)->nullable(false)->change();
            $table->text('school_address')->nullable(false)->change();
            $table->integer('graduation_year')->nullable(false)->change();
            $table->string('certificate_number')->nullable(false)->change();
            $table->decimal('average_score', 5, 2)->nullable(false)->change();
        });
    }
};