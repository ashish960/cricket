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
        Schema::create('setgames', function (Blueprint $table) {
            $table->string('game_id')->unique()->primary();
            $table->string('game_name');
            $table->string('no_of_teams');
            $table->string('no_of_players');
            $table->string('no_of_overs');
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
        Schema::dropIfExists('setgames');
    }
};
