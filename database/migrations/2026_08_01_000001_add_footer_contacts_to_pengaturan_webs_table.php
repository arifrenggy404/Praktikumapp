<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_webs', function (Blueprint $table) {
            $table->string('facebook_url')->nullable()->after('email_gereja');
            $table->string('youtube_url')->nullable()->after('facebook_url');
            $table->string('instagram_url')->nullable()->after('youtube_url');
            $table->string('jam_operasional')->nullable()->default('Senin - Sabtu: 08.00 - 16.00 WITA')->after('instagram_url');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_webs', function (Blueprint $table) {
            $table->dropColumn(['facebook_url', 'youtube_url', 'instagram_url', 'jam_operasional']);
        });
    }
};
