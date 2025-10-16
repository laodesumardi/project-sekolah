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
        Schema::table('messages', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('messages', 'from_student_id')) {
                $table->foreignId('from_student_id')->nullable()->constrained('users')->onDelete('cascade')->after('id');
            }
            if (!Schema::hasColumn('messages', 'to_type')) {
                $table->string('to_type')->nullable()->after('from_student_id'); // teacher, homeroom, admin
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'from_student_id')) {
                $table->dropForeign(['from_student_id']);
                $table->dropColumn('from_student_id');
            }
            if (Schema::hasColumn('messages', 'to_type')) {
                $table->dropColumn('to_type');
            }
        });
    }
};