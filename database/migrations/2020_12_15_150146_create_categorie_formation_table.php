<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieFormationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('categorie_formation')) {

            Schema::create('categorie_formation', function (Blueprint $table) {
                $table->id();
                $table->integer('categorie_id');
                $table->integer('formation_id');

                // $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
                // $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade')->onUpdate('cascade');
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorie_formation');
    }
}
