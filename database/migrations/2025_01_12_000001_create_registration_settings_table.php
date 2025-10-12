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
        Schema::create('registration_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('announcement_date');
            $table->integer('quota_regular')->default(0);
            $table->integer('quota_achievement')->default(0);
            $table->integer('quota_affirmation')->default(0);
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->boolean('is_open')->default(false);
            $table->text('information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_settings');
    }
};

