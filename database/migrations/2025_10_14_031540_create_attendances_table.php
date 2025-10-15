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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('profiles')->onDelete('cascade');
            $table->foreignId('teacher_class_id')->constrained('teacher_classes')->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'sick', 'permission'])->default('present');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['student_id', 'teacher_class_id', 'date']);
            $table->index(['teacher_class_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};