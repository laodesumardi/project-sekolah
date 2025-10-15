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
            if (!Schema::hasColumn('achievements', 'achievement_date')) {
                $table->date('achievement_date')->nullable()->after('date');
            }
            if (!Schema::hasColumn('achievements', 'year')) {
                $table->integer('year')->nullable()->after('achievement_date');
            }
            if (!Schema::hasColumn('achievements', 'organizer')) {
                $table->string('organizer')->nullable()->after('year');
            }
            if (!Schema::hasColumn('achievements', 'location')) {
                $table->string('location')->nullable()->after('organizer');
            }
            if (!Schema::hasColumn('achievements', 'prize')) {
                $table->string('prize')->nullable()->after('location');
            }
            if (!Schema::hasColumn('achievements', 'score')) {
                $table->string('score')->nullable()->after('prize');
            }
            if (!Schema::hasColumn('achievements', 'video_url')) {
                $table->string('video_url')->nullable()->after('score');
            }
            if (!Schema::hasColumn('achievements', 'news_url')) {
                $table->string('news_url')->nullable()->after('video_url');
            }
            if (!Schema::hasColumn('achievements', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('news_url');
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
                'achievement_date', 'year', 'organizer', 'location',
                'prize', 'score', 'video_url', 'news_url', 'sort_order'
            ]);
        });
    }
};
