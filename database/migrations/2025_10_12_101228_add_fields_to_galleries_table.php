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
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->after('image');
            $table->string('alt_text')->nullable()->after('thumbnail');
            $table->string('file_size')->nullable()->after('alt_text');
            $table->string('dimensions')->nullable()->after('file_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['thumbnail', 'alt_text', 'file_size', 'dimensions']);
        });
    }
};