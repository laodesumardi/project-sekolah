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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category');
            $table->enum('achievement_level', ['kecamatan', 'kota', 'provinsi', 'nasional', 'internasional']);
            $table->string('rank');
            $table->enum('participant_type', ['individual', 'team']);
            $table->text('participant_names');
            $table->date('date');
            $table->string('certificate_image')->nullable();
            $table->string('competition_name')->nullable();
            $table->string('organizer')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};