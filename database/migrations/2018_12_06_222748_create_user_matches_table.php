<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_matches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('league_id', 100);
            $table->string("platformId", 20); // "BR1"
            $table->integer("gameId")->unique();; // 1439202755
            $table->integer("champion"); // 25
            $table->integer("queue"); // 420
            $table->integer("season"); // 11
            $table->string("timestamp", 20); // 1533410677598.0
            $table->string("role", 20); // "DUO_SUPPORT"
            $table->string("lane", 20); // "BOTTOM"
            $table->timestamps();
            $table->foreign('league_id')->references('league_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_matches');
    }
}
