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
        Schema::create('extracurricular_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extracurricular_id')->constrained('extracurriculars')->onDelete('cascade');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->enum('achievement_level', ['sekolah', 'kecamatan', 'kota', 'provinsi', 'nasional', 'internasional']);
            $table->string('rank', 100)->nullable();
            $table->string('event_name', 255);
            $table->date('date');
            $table->string('certificate_image', 255)->nullable();
            $table->text('participants')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index(['extracurricular_id']);
            $table->index(['date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_achievements');
    }
};
