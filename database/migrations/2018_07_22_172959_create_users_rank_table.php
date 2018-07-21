<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_rank', function (Blueprint $table) {
            $table->increments('id');
            $table->string('league_id', 100);
            $table->string('leagueName', 100)->nullable();;
            $table->string('tier', 100)->nullable();;
            $table->string('rank', 100)->nullable();;
            $table->string('leaguePoints', 100)->nullable();;
            $table->string('wins', 100)->nullable();;
            $table->string('losses', 100)->nullable();;
            $table->string('veteran', 100)->nullable();;
            $table->string('inactive', 100)->nullable();;
            $table->string('freshBlood', 100)->nullable();;
            $table->string('hotStreak', 100)->nullable();;
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
        Schema::dropIfExists('users_rank');
    }
}
