<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('phone_number')->unique()->nullable()->after('email');
            $table->string('google_id')->unique()->nullable()->after('remember_token');
            $table->string('google_token')->nullable()->after('google_id');
            $table->string('google_refresh_token')->nullable()->after('google_token');
            $table->string('avatar_url')->nullable()->after('google_refresh_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'phone_number',
                'google_id',
                'google_token',
                'google_refresh_token',
                'avatar_url',
            ]);
        });
    }
};
