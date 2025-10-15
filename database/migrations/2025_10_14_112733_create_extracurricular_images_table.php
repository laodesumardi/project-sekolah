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
        Schema::create('extracurricular_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extracurricular_id')->constrained('extracurriculars')->onDelete('cascade');
            $table->string('image', 255);
            $table->string('thumbnail', 255);
            $table->string('title', 255)->nullable();
            $table->enum('image_type', ['activity', 'achievement', 'facility', 'team', 'other']);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index(['extracurricular_id']);
            $table->index(['image_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_images');
    }
};
