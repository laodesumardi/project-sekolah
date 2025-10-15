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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->enum('category', [
                'ruang_kelas', 
                'laboratorium', 
                'olahraga', 
                'perpustakaan', 
                'mushola', 
                'kantin', 
                'lainnya'
            ]);
            $table->text('description');
            $table->integer('capacity')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('image', 255);
            $table->string('thumbnail', 255)->nullable();
            $table->boolean('is_available')->default(true);
            $table->string('floor', 50)->nullable();
            $table->text('facilities_spec')->nullable();
            $table->integer('sort_order')->default(0);
            $table->integer('view_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('slug');
            $table->index('category');
            $table->index('is_available');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};