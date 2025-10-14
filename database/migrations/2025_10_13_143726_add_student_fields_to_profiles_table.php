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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('parent_phone');
            $table->text('address')->nullable()->after('phone');
            $table->string('profile_picture')->nullable()->after('address');
            $table->text('bio')->nullable()->after('profile_picture');
            $table->boolean('show_profile_to_students')->default(true)->after('bio');
            $table->boolean('show_email_to_teachers')->default(true)->after('show_profile_to_students');
            $table->boolean('allow_parent_access')->default(true)->after('show_email_to_teachers');
            $table->boolean('two_factor_enabled')->default(false)->after('allow_parent_access');
            $table->string('two_factor_secret')->nullable()->after('two_factor_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'address',
                'profile_picture',
                'bio',
                'show_profile_to_students',
                'show_email_to_teachers',
                'allow_parent_access',
                'two_factor_enabled',
                'two_factor_secret',
            ]);
        });
    }
};