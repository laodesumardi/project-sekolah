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
        Schema::create('ppdb_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('ppdb_settings')->insert([
            [
                'key' => 'registration_period_start',
                'value' => date('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'registration_period_end',
                'value' => date('Y-m-d', strtotime('+3 months')),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'quota',
                'value' => '200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'is_open',
                'value' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'description',
                'value' => 'Penerimaan Peserta Didik Baru SMP Negeri 01 Namrole Tahun Ajaran 2024/2025',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'requirements',
                'value' => '• Usia maksimal 15 tahun pada 1 Juli 2024\n• Memiliki ijazah SD/MI atau sederajat\n• Foto berwarna 3x4 (2 lembar)\n• Fotokopi akta kelahiran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_phone',
                'value' => '(021) 1234-5678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_email',
                'value' => 'ppdb@smpn01namrole.sch.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '0812-3456-7890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jl. Pendidikan No. 1, Namrole',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'hero_title',
                'value' => 'PPDB 2024',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Penerimaan Peserta Didik Baru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'hero_description',
                'value' => 'Bergabunglah dengan keluarga besar SMP Negeri 01 Namrole',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_settings');
    }
};