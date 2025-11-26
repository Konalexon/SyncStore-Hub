<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->default(0);
        });

        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon'); // Emoji or image URL
            $table->string('description');
            $table->string('type'); // 'chat', 'spend', 'win', 'register'
            $table->integer('threshold'); // Value needed to unlock
            $table->timestamps();
        });

        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('badge_id')->constrained()->onDelete('cascade');
            $table->timestamp('awarded_at')->useCurrent();
            $table->timestamps();
        });

        // Seed initial badges
        DB::table('badges')->insert([
            ['name' => 'Newbie', 'icon' => '🔰', 'description' => 'Welcome to the community!', 'type' => 'register', 'threshold' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chatterbox', 'icon' => '🗣️', 'description' => 'Sent 10 messages.', 'type' => 'chat', 'threshold' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Big Spender', 'icon' => '💸', 'description' => 'Spent over $500.', 'type' => 'spend', 'threshold' => 500, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Winner', 'icon' => '🏆', 'description' => 'Won your first auction.', 'type' => 'win', 'threshold' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('badges');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('points');
        });
    }
};
