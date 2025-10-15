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
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->onDelete('cascade');
            $table->string('image', 255);
            $table->string('thumbnail', 255);
            $table->string('medium', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('caption')->nullable();
            $table->string('alt_text', 255)->nullable();
            $table->integer('file_size');
            $table->string('mime_type', 50);
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_cover')->default(false);
            $table->integer('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('gallery_id');
            $table->index('is_cover');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
    }
};