<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfosSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infos_systems', function (Blueprint $table) {
            $table->id();
            $table->string('system_name')->default("Plateforme E-learning");
            $table->string('system_email');
            $table->string('address');
            $table->string('fixe');
            $table->string('mobile');
            $table->string('logo');
            $table->string('favicon');
            $table->string('img_header');
            $table->string('img_slider');

            $table->string('facebook')->default("facebook");
            $table->string('insta')->default("insta");
            $table->string('twitter')->default("twitter");
            $table->string('linkedin')->default("linkedin");
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
        Schema::dropIfExists('infos_systems');
    }
}
