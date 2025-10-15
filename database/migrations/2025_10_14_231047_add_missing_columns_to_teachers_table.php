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
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('teachers', 'photo')) {
                $table->string('photo')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'bio')) {
                $table->text('bio')->nullable();
            }
            if (!Schema::hasColumn('teachers', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['photo', 'bio', 'is_active']);
        });
    }
};
