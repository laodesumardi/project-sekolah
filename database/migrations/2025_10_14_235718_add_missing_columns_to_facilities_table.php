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
        Schema::table('facilities', function (Blueprint $table) {
            // Add any missing columns that might be needed
            if (!Schema::hasColumn('facilities', 'image')) {
                $table->string('image')->nullable()->after('facilities_spec');
            }
            if (!Schema::hasColumn('facilities', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('image');
            }
            if (!Schema::hasColumn('facilities', 'is_available')) {
                $table->boolean('is_available')->default(true)->after('thumbnail');
            }
            if (!Schema::hasColumn('facilities', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_available');
            }
            if (!Schema::hasColumn('facilities', 'view_count')) {
                $table->integer('view_count')->default(0)->after('sort_order');
            }
            if (!Schema::hasColumn('facilities', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('view_count');
            }
            if (!Schema::hasColumn('facilities', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn([
                'image', 'thumbnail', 'is_available', 'sort_order',
                'view_count', 'created_by', 'updated_by'
            ]);
        });
    }
};
