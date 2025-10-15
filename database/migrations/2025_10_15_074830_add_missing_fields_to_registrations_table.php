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
            // Add only missing fields that don't exist yet
            if (!Schema::hasColumn('registrations', 'school_origin')) {
                $table->string('school_origin')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'child_order')) {
                $table->integer('child_order')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'ijazah')) {
                $table->string('ijazah')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'skhun')) {
                $table->string('skhun')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'kk')) {
                $table->string('kk')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'akta_kelahiran')) {
                $table->string('akta_kelahiran')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'ktp_ortu')) {
                $table->string('ktp_ortu')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'village')) {
                $table->string('village')->nullable();
            }
            if (!Schema::hasColumn('registrations', 'district')) {
                $table->string('district')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'school_origin',
                'school_address', 
                'child_order',
                'ijazah',
                'skhun',
                'kk',
                'akta_kelahiran',
                'ktp_ortu',
                'village',
                'district'
            ]);
        });
    }
};