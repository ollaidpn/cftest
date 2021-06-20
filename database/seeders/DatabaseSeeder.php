<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'title' => 'Administrateur Technique',
                'slug' => 'admin',
                'description' => 'L\'administrateur du site',
            ],
            [
                'id' => 2,
                'title' => 'Administrateur Pédagogique',
                'slug' => 'educational-admin',
                'description' => 'Administrateur pédagogique',
            ],
            [
                'id' => 3,
                'title' => 'Formateur',
                'slug' => 'teacher',
                'description' => 'Formateur',
            ],
            [
                'id' => 4,
                'title' => 'Apprenant',
                'slug' => 'student',
                'description' => 'Apprenant',
            ]
        ];

        $admin = [
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'country' => 'Sénégal',
            'gender' => 'Homme',
            'phone' => '+221 77 777 77 77',
            'role_id' => 1,
            'email' => 'admin@futurschoisis.com',
            'password' => Hash::make('@FC2020'),
        ];

        Role::insert($roles);
        User::insert($admin);
    }
}
