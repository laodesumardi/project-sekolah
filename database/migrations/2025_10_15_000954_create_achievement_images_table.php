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
        Schema::create('achievement_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('image_type')->default('documentation'); // certificate, trophy, documentation
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_images');
    }
};
