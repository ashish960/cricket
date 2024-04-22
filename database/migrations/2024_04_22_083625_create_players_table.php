<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('player_name');
            $table->string('player_no');
            $table->string('team_no');
            $table->string('player_status')->comment("1:Active,0:Inactive,2:out,3:stand")->default(0);
            $table->string('game_id');
            $table->foreign('game_id')->references('game_id')->on('setgames');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
};
