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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->foreignId('registration_setting_id')->constrained('registration_settings')->onDelete('cascade');
            $table->enum('registration_path', ['regular', 'achievement', 'affirmation']);
            
            // Data Pribadi Siswa
            $table->string('full_name');
            $table->string('nik', 16)->unique();
            $table->string('nisn', 10)->unique();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P']);
            $table->string('religion');
            $table->integer('child_number');
            $table->integer('siblings_count');
            $table->text('address');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code', 5);
            $table->string('phone', 15);
            $table->string('email');
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('blood_type')->nullable();
            $table->text('medical_history')->nullable();
            $table->string('photo')->nullable();
            
            // Data Orang Tua
            $table->string('father_name');
            $table->string('father_nik', 16);
            $table->integer('father_birth_year');
            $table->string('father_education');
            $table->string('father_occupation');
            $table->string('father_income');
            $table->string('father_phone', 15);
            $table->string('mother_name');
            $table->string('mother_nik', 16);
            $table->integer('mother_birth_year');
            $table->string('mother_education');
            $table->string('mother_occupation');
            $table->string('mother_income');
            $table->string('mother_phone', 15);
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->string('guardian_phone', 15)->nullable();
            
            // Data Pendidikan
            $table->string('previous_school');
            $table->string('school_npsn', 8);
            $table->text('school_address');
            $table->integer('graduation_year');
            $table->string('certificate_number');
            $table->decimal('average_score', 5, 2);
            $table->text('achievements')->nullable();
            
            // Status & Tracking
            $table->enum('status', ['pending', 'verified', 'accepted', 'rejected', 'reserved'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('announced_at')->nullable();
            $table->enum('payment_status', ['unpaid', 'paid', 'confirmed'])->default('unpaid');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
