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
        Schema::table('subjects', function (Blueprint $table) {
            // Check if code column exists and make it nullable or add default value
            if (Schema::hasColumn('subjects', 'code')) {
                $table->string('code')->nullable()->change();
            } else {
                // Add code column if it doesn't exist
                $table->string('code')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            if (Schema::hasColumn('subjects', 'code')) {
                $table->string('code')->nullable(false)->change();
            }
        });
    }
};
