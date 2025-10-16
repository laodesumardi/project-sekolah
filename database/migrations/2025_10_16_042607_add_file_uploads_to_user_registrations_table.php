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
        Schema::table('user_registrations', function (Blueprint $table) {
            // File uploads for PPDB
            $table->string('photo_3x4', 255)->nullable()->comment('Foto 3x4');
            $table->string('birth_certificate', 255)->nullable()->comment('Akta Kelahiran');
            $table->string('family_card', 255)->nullable()->comment('Kartu Keluarga');
            $table->string('diploma', 255)->nullable()->comment('Ijazah SD/MI');
            $table->string('report_card', 255)->nullable()->comment('Rapor SD/MI');
            $table->string('parent_id_card', 255)->nullable()->comment('KTP Orang Tua');
            $table->string('other_documents', 500)->nullable()->comment('Dokumen Lainnya (JSON)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'photo_3x4',
                'birth_certificate', 
                'family_card',
                'diploma',
                'report_card',
                'parent_id_card',
                'other_documents'
            ]);
        });
    }
};