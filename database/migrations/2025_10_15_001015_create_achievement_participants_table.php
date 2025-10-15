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
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('profiles')->onDelete('cascade');
            $table->string('role')->default('participant'); // participant, leader, member
            $table->text('notes')->nullable();
            $table->timestamps();
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
