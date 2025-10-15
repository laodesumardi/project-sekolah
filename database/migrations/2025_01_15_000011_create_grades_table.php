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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('profiles')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('school_classes')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('assignment_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('grade_type', ['assignment', 'quiz', 'exam', 'project', 'attendance', 'other']);
            $table->decimal('score', 5, 2);
            $table->decimal('max_score', 5, 2);
            $table->text('description')->nullable();
            $table->datetime('graded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
