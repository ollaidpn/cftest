<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formation_team', function (Blueprint $table) {
            $table->id();
            $table->integer('formation_id');
            $table->integer('team_id');

            // $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreignId('team_id')->constrained('teams')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('formation_team');
    }
}
