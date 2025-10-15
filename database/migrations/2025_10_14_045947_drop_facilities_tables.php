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
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('facility_categories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate facilities table
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image')->nullable();
            $table->integer('capacity')->nullable();
            $table->boolean('is_available')->default(true);
            $table->foreignId('category_id')->nullable()->constrained('facility_categories')->onDelete('set null');
            $table->timestamps();
        });

        // Recreate facility_categories table
        Schema::create('facility_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
};