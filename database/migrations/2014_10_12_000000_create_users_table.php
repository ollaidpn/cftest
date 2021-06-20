<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
            $table->integer('role_id');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();

            $table->string('phone');
            $table->string('email');

            $table->string('country')->nullable();
            $table->string('address')->nullable();
            // $table->foreignId('role_id')->constrained('roles')->onDelete('restrict')->onUpdate('restrict')->nullable();
            // $table->integer('organization_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            [array(
                'role_id' => '1',
                'first_name' => 'Administrateur ',
                'last_name' => 'Technique',
                'phone' => '770000000',
                'email' => 'admin@fc.com',
                'password' => '$2y$10$eU2vvHab0Q6Ut0HIwuduOefqRTQSsBhBtJpCWvxFcIWi3zBxyKJ6u',
                'created_at' => '2021-03-08 09:00:05',
            ),array(
                'role_id' => '2',
                'first_name' => 'Administrateur',
                'last_name' => 'Pédagogique',
                'phone' => '770000000',
                'email' => 'adminp@fc.com',
                'password' => '$2y$10$eU2vvHab0Q6Ut0HIwuduOefqRTQSsBhBtJpCWvxFcIWi3zBxyKJ6u',
                'created_at' => '2021-03-08 09:00:05',
            ),
            array(
                'role_id' => '3',
                'first_name' => 'Formateur ',
                'last_name' => 'Formateur',
                'phone' => '770000000',
                'email' => 'formateur@fc.com',
                'password' => '$2y$10$eU2vvHab0Q6Ut0HIwuduOefqRTQSsBhBtJpCWvxFcIWi3zBxyKJ6u',
                'created_at' => '2021-03-08 09:00:05',
            ),
            array(
                'role_id' => '4',
                'first_name' => 'Apprenant ',
                'last_name' => 'Apprenant',
                'phone' => '770000000',
                'email' => 'apprenant@fc.com',
                'password' => '$2y$10$eU2vvHab0Q6Ut0HIwuduOefqRTQSsBhBtJpCWvxFcIWi3zBxyKJ6u',
                'created_at' => '2021-03-08 09:00:05',
            ),

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
        Schema::dropIfExists('users');
    }
}
