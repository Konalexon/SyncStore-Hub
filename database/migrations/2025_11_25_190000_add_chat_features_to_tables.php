<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_banned')->default(false);
        });

        Schema::table('live_streams', function (Blueprint $table) {
            $table->string('pinned_message')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_banned');
        });

        Schema::table('live_streams', function (Blueprint $table) {
            $table->dropColumn('pinned_message');
        });
    }
};
