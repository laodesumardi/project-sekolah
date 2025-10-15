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
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->enum('category', ['akademik', 'olahraga', 'seni', 'teknologi', 'keagamaan', 'lomba', 'kompetisi', 'olimpiade', 'lainnya']);
            $table->text('description');
            $table->enum('achievement_level', ['sekolah', 'kecamatan', 'kota', 'provinsi', 'nasional', 'internasional']);
            $table->string('rank', 100);
            $table->string('event_name', 255);
            $table->string('organizer', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->date('date');
            $table->integer('year');
            $table->enum('participant_type', ['individu', 'kelompok', 'tim']);
            $table->text('participants')->nullable();
            $table->text('student_ids')->nullable();
            $table->text('teacher_ids')->nullable();
            $table->string('certificate_image', 255)->nullable();
            $table->string('trophy_image', 255)->nullable();
            $table->text('documentation_images')->nullable();
            $table->string('video_url', 255)->nullable();
            $table->string('news_url', 255)->nullable();
            $table->text('prize')->nullable();
            $table->string('score', 100)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->integer('view_count')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('category');
            $table->index('achievement_level');
            $table->index('date');
            $table->index('year');
            $table->index('is_featured');
            $table->index('is_published');
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
