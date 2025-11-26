<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->timestamp('auction_end_time')->nullable();
        });
    }

    public function down()
    {
        Schema::table('live_streams', function (Blueprint $table) {
            $table->dropColumn('auction_end_time');
        });
    }
};
