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
        Schema::create('extracurricular_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extracurricular_id')->constrained('extracurriculars')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('profiles')->onDelete('cascade');
            $table->datetime('registration_date');
            $table->enum('status', ['pending', 'approved', 'rejected', 'active', 'inactive']);
            $table->text('reason')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->datetime('approved_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['extracurricular_id']);
            $table->index(['student_id']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_registrations');
    }
};
