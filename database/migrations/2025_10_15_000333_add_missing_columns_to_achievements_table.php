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
        Schema::table('achievements', function (Blueprint $table) {
            // Add any missing columns that might be needed
            if (!Schema::hasColumn('achievements', 'title')) {
                $table->string('title')->after('id');
            }
            if (!Schema::hasColumn('achievements', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }
            if (!Schema::hasColumn('achievements', 'category')) {
                $table->string('category')->after('slug');
            }
            if (!Schema::hasColumn('achievements', 'achievement_level')) {
                $table->string('achievement_level')->after('category');
            }
            if (!Schema::hasColumn('achievements', 'rank')) {
                $table->string('rank')->after('achievement_level');
            }
            if (!Schema::hasColumn('achievements', 'event_name')) {
                $table->string('event_name')->after('rank');
            }
            if (!Schema::hasColumn('achievements', 'date')) {
                $table->date('date')->after('event_name');
            }
            if (!Schema::hasColumn('achievements', 'participant_type')) {
                $table->string('participant_type')->after('date');
            }
            if (!Schema::hasColumn('achievements', 'description')) {
                $table->text('description')->after('participant_type');
            }
            if (!Schema::hasColumn('achievements', 'certificate_image')) {
                $table->string('certificate_image')->nullable()->after('description');
            }
            if (!Schema::hasColumn('achievements', 'trophy_image')) {
                $table->string('trophy_image')->nullable()->after('certificate_image');
            }
            if (!Schema::hasColumn('achievements', 'documentation_images')) {
                $table->json('documentation_images')->nullable()->after('trophy_image');
            }
            if (!Schema::hasColumn('achievements', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('documentation_images');
            }
            if (!Schema::hasColumn('achievements', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_published');
            }
            if (!Schema::hasColumn('achievements', 'views')) {
                $table->integer('views')->default(0)->after('is_featured');
            }
            if (!Schema::hasColumn('achievements', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('views');
            }
            if (!Schema::hasColumn('achievements', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'slug', 'category', 'achievement_level', 'rank',
                'event_name', 'date', 'participant_type', 'description',
                'certificate_image', 'trophy_image', 'documentation_images',
                'is_published', 'is_featured', 'views', 'created_by', 'updated_by'
            ]);
        });
    }
};
