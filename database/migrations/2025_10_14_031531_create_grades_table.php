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
            $table->foreignId('student_id')->constrained('profiles')->onDelete('cascade');
            $table->foreignId('teacher_class_id')->constrained('teacher_classes')->onDelete('cascade');
            $table->decimal('score', 5, 2);
            $table->integer('semester')->default(1);
            $table->enum('grade_type', ['quiz', 'assignment', 'midterm', 'final', 'project', 'other'])->default('quiz');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['student_id', 'teacher_class_id', 'semester']);
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