<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stream_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_stream_id')->constrained()->onDelete('cascade');
            $table->integer('viewer_count');
            $table->timestamps();
        });

        Schema::create('stream_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_stream_id')->constrained()->onDelete('cascade');
            $table->enum('interaction_type', ['click', 'purchase']);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stream_interactions');
        Schema::dropIfExists('stream_analytics');
    }
};
