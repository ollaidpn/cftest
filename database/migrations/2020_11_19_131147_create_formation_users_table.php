<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formation_user', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('formation_id');
            $table->integer('team_id')->nullable();

            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('process')->default(0);
            $table->string('status')->nullable();
            $table->string('actual_content_id')->nullable();
            $table->text('ended_contents')->nullable();
            $table->text('suspended_quiz')->nullable();
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
        Schema::dropIfExists('formation_user');
    }
}
