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
        Schema::create('extracurriculars', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->enum('category', ['olahraga', 'seni', 'akademik', 'keagamaan', 'teknologi', 'bahasa', 'sosial', 'lainnya']);
            $table->text('description');
            $table->string('short_description', 500)->nullable();
            $table->foreignId('instructor_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->string('instructor_name', 255)->nullable();
            $table->enum('schedule_day', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'])->nullable();
            $table->time('schedule_time_start')->nullable();
            $table->time('schedule_time_end')->nullable();
            $table->string('location', 255)->nullable();
            $table->integer('max_participants')->nullable();
            $table->integer('current_participants')->default(0);
            $table->boolean('is_registration_open')->default(true);
            $table->date('registration_start')->nullable();
            $table->date('registration_end')->nullable();
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->integer('view_count')->default(0);
            $table->string('facebook_url', 255)->nullable();
            $table->string('instagram_url', 255)->nullable();
            $table->string('youtube_url', 255)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['slug']);
            $table->index(['category']);
            $table->index(['is_active']);
            $table->index(['is_featured']);
            $table->index(['instructor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurriculars');
    }
};
