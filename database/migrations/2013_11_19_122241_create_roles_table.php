<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('slug');
            $table->timestamps();
        });

        // DB::table('roles')->insert(
        //     array(
        //         'title' => 'Avec Tontine',
        //         'FirstLine' => 'Acheter vos matériels (Salon, Chambre a couché, voitures...)',
        //         'SecondLine' => 'Payer comme vous le pouvez',
        //         'link' => '',
        //         // 'preloader_logo' => '',
        //         'bg_image' => '12345',

        //     )
        // );
        DB::table('roles')->insert(
            [array(
                'title' => 'Administrateur Technique',
                'description' => 'L\'administrateur du site',
                'slug' => 'admin',
                'created_at' => '2021-03-08 09:00:05',
            ),
            array(
                'title' => 'Administrateur Pédagogique',
                'description' => 'Administrateur pédagogique',
                'slug' => 'educational-admin',
                'created_at' => '2021-03-08 09:00:05',
            ),
            array(
                'title' => 'Formateur',
                'description' => 'Formateur',
                'slug' => 'teacher',
                'created_at' => '2021-03-08 09:00:05',
            ),

            array(
                'title' => 'Apprenant',
                'description' => 'Apprenant',
                'slug' => 'student',
                'created_at' => '2021-03-08 09:00:05',
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
        Schema::dropIfExists('roles');
    }
}
