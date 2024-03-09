<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $admin = ([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role_id' => 2,
        ]);


        User::create($admin);

        $faker = Faker::create();
        for($i = 0; $i < 15; $i++){
            User::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->email(),
                'password' => Hash::make('sifra123'),
                'role_id' => 1,
            ]);
        }
    }
}
