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
        Schema::table('registrations', function (Blueprint $table) {
            // Make occupation fields nullable
            $table->string('father_occupation')->nullable()->change();
            $table->string('mother_occupation')->nullable()->change();
            
            // Also make other optional fields nullable
            $table->string('father_income')->nullable()->change();
            $table->string('mother_income')->nullable()->change();
            $table->string('father_phone', 15)->nullable()->change();
            $table->string('mother_phone', 15)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Revert occupation fields to not nullable
            $table->string('father_occupation')->nullable(false)->change();
            $table->string('mother_occupation')->nullable(false)->change();
            
            // Revert other fields
            $table->string('father_income')->nullable(false)->change();
            $table->string('mother_income')->nullable(false)->change();
            $table->string('father_phone', 15)->nullable(false)->change();
            $table->string('mother_phone', 15)->nullable(false)->change();
        });
    }
};
