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
            $table->string('event_name')->nullable()->after('rank');
            $table->date('date')->nullable()->after('event_name');
            $table->integer('year')->nullable()->after('date');
            $table->string('participant_type')->nullable()->after('year');
            $table->json('student_ids')->nullable()->after('participant_type');
            $table->json('teacher_ids')->nullable()->after('student_ids');
            $table->string('certificate_image')->nullable()->after('teacher_ids');
            $table->string('trophy_image')->nullable()->after('certificate_image');
            $table->json('documentation_images')->nullable()->after('trophy_image');
            $table->string('video_url')->nullable()->after('documentation_images');
            $table->string('news_url')->nullable()->after('video_url');
            $table->string('prize')->nullable()->after('news_url');
            $table->decimal('score', 5, 2)->nullable()->after('prize');
            $table->unsignedBigInteger('created_by')->nullable()->after('score');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn([
                'event_name', 'date', 'year', 'participant_type',
                'student_ids', 'teacher_ids', 'certificate_image',
                'trophy_image', 'documentation_images', 'video_url',
                'news_url', 'prize', 'score', 'created_by', 'updated_by'
            ]);
        });
    }
};
