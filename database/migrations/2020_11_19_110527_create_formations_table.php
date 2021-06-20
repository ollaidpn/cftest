<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFormationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('nb_hours');
            $table->text('presentation_text');
            $table->string('image');
            $table->string('type');
            $table->integer('price')->default(0);
            $table->integer('views')->default(0);
            $table->integer('timeline')->nullable();
            $table->string('presentation_video');
            $table->boolean('show_stats')->default(false);
            $table->string('uri_folder');
            $table->text('practical_informations')->nullable();
            $table->string('slug');
            $table->integer('team_id')->nullable();

            // $table->foreignId('team_id')->constrained('teams')->onDelete('set null')->onUpdate('cascade')->nullable();
            $table->timestamps();
        });

        // DB::table('users')->insert(
        //     [array(
        //         'title' => 'Formation 1',
        //         'nb_hours' => '2 ',
        //         'presentation_text' => 'description cours 1',
        //         'image' => '770000000',
        //         'type' => 'admin@fc.com',
        //         'price' => '$2y$10$eU2vvHab0Q6Ut0HIwuduOefqRTQSsBhBtJpCWvxFcIWi3zBxyKJ6u',
        //         'presentation_video' => '2021-03-08 09:00:05',
        //         'uri_folder' => '/users/128979002/projects/3357102',
        //         'practical_informations' => '2021-03-08 09:00:05',
        //         'slug' => '2021-03-08 09:00:05',
        //         'team_id' => '2021-03-08 09:00:05',


        //     ]
        // );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formations');
    }
}
