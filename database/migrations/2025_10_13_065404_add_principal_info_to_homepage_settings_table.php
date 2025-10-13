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
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->string('principal_name')->nullable()->after('contact_address');
            $table->string('principal_title')->nullable()->after('principal_name');
            $table->text('principal_message')->nullable()->after('principal_title');
            $table->string('principal_photo')->nullable()->after('principal_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropColumn(['principal_name', 'principal_title', 'principal_message', 'principal_photo']);
        });
    }
};
