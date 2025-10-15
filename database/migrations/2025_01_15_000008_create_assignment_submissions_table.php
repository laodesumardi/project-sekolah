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
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('profiles')->onDelete('cascade');
            $table->text('submission_text')->nullable();
            $table->string('file_path')->nullable();
            $table->datetime('submitted_at');
            $table->decimal('score', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->datetime('graded_at')->nullable();
            $table->boolean('is_late')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
