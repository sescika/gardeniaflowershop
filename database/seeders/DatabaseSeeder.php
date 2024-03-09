<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            MenuSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
            ImageSeeder::class,
            CategorySeeder::class,
            FlowerSeeder::class,
            PriceSeeder::class,
        ]);
    }
}
