<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();
        for ($i = 1; $i <= 33; $i++) {
            Price::create([
                'flower_id' => $i,
                'price' => $faker->randomFloat(2, 20.99, 199.99),
                'currency_code' => "EUR",
                'effective_date' => '2024-12-12 23:59:59'
            ]);
        }
    }
}
