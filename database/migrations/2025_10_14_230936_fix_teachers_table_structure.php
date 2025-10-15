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
        // Check if teachers table exists and has the wrong structure
        if (Schema::hasTable('teachers')) {
            // Drop the existing teachers table if it has wrong structure
            Schema::dropIfExists('teachers');
        }
        
        // Create the correct teachers table structure
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nip')->unique();
            $table->string('nik')->unique();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['L', 'P']);
            $table->string('religion');
            $table->text('address');
            $table->string('phone');
            $table->string('employment_status');
            $table->date('join_date');
            $table->string('education_level');
            $table->string('major')->nullable();
            $table->string('university')->nullable();
            $table->integer('graduation_year')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
