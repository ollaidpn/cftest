<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('slug');
            $table->integer('category_parent')->nullable();

            // $table->foreignId('category_parent')->constrained('categories')->onDelete('set null')->onUpdate('cascade')->nullable();
            $table->timestamps();
        });

        DB::table('categories')->insert(
            [array(
                'title' => 'Informatique',
                'slug' => 'Informatique',
                'category_parent' => null,

            ),array(
                'title' => 'Développement Web',
                'slug' => 'DéveloppementWeb',
                'category_parent' => '1',

            )
            ,array(
                'title' => 'Infographie',
                'slug' => 'Infographie',
                'category_parent' => '1',

            )
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
