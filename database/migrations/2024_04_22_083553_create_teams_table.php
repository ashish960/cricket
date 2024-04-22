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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('team_name');
            $table->string('team_no');
            $table->string('team_current_size')->nullable();
            $table->string('team_status')->comment("1:Batting,0:Bowling")->default(0);
            $table->string('team_score')->default(0);
            $table->string('team_current_overs')->deafault(0);
            $table->string('current_over_ball')->default(0);
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
        Schema::dropIfExists('teams');
    }
};
