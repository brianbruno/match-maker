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
            $table->string('leagueName', 30)->nullable();
            $table->string('tier', 20)->nullable();
            $table->string('rank', 20)->nullable();
            $table->integer('leaguePoints')->nullable();
            $table->integer('wins')->nullable();
            $table->integer('losses')->nullable();
            $table->string('queueType', 20);
            $table->string('veteran', 20)->nullable();
            $table->string('inactive', 20)->nullable();
            $table->string('freshBlood', 20)->nullable();
            $table->string('hotStreak', 20)->nullable();
            $table->timestamps();

            $table->foreign('league_id')->references('league_id')->on('users');

            $table->unique(['league_id', 'queueType']);
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
