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
        Schema::create('user_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number', 50)->unique();
            $table->enum('registration_type', ['student', 'parent', 'teacher']);
            
            // Data Pribadi
            $table->string('full_name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone', 20);
            $table->string('nik', 16)->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('postal_code', 10)->nullable();
            
            // Data Tambahan (untuk Siswa)
            $table->string('school_origin', 255)->nullable();
            $table->string('last_education', 100)->nullable();
            $table->integer('graduation_year')->nullable();
            $table->string('nisn', 20)->nullable();
            
            // Data Tambahan (untuk Orang Tua)
            $table->enum('relation_type', ['ayah', 'ibu', 'wali'])->nullable();
            $table->string('occupation', 100)->nullable();
            $table->string('student_name', 255)->nullable();
            $table->string('student_nis', 20)->nullable();
            
            // Password
            $table->string('password', 255);
            
            // Verifikasi
            $table->string('email_verification_token', 100)->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_verification_code', 10)->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            
            // Status & Approval
            $table->enum('status', ['pending', 'verified', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            
            // Terms & Privacy
            $table->boolean('agreed_to_terms')->default(false);
            $table->boolean('agreed_to_privacy')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['registration_number', 'email', 'phone', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_registrations');
    }
};
