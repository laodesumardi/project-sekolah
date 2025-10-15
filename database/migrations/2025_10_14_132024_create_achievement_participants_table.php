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
        Schema::create('achievement_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained('achievements')->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->constrained('profiles')->onDelete('cascade');
            $table->string('participant_name', 255);
            $table->enum('role', ['peserta', 'ketua', 'wakil', 'anggota', 'cadangan']);
            $table->string('class_name', 100)->nullable();
            $table->timestamps();

            // Indexes
            $table->index('achievement_id');
            $table->index('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_participants');
    }
};
