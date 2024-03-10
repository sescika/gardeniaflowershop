<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 33; $i++) {
            Image::create([
                'img_name' => $i . '_flower',
                'path' => 'assets/img/'.$i . '.jpg',
            ]);
        }
    }
}
