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
        Schema::table('teachers', function (Blueprint $table) {
            // Ensure all required columns exist with proper defaults
            if (!Schema::hasColumn('teachers', 'photo')) {
                $table->string('photo')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'bio')) {
                $table->text('bio')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('teachers', 'education')) {
                $table->string('education')->nullable();
            }
            
            // Make sure nullable fields are properly set
            $table->string('major')->nullable()->change();
            $table->string('university')->nullable()->change();
            $table->integer('graduation_year')->nullable()->change();
            $table->text('bio')->nullable()->change();
            $table->string('photo')->nullable()->change();
            $table->string('education')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Revert changes if needed
            $table->string('education')->nullable(false)->change();
        });
    }
};
