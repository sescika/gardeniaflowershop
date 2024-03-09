<?php

namespace Database\Seeders;

use App\Models\Flower;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class FlowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $flowerNames = [
        'What a Treat!',
        'Blooming Bounty Bouquet',
        'Natural Wonders Basket',
        'Pretty Please',
        'Joyfull and Thrilling',
        'The Sweetest Blooms',
        'Sunny Sentiments',
        'Brighten Your Day',
        'Dancing in Daisies',
        'Six Red Roses in a Vase',
        'FTD\'s Sunny Sentiments',
        'Woodland Greens Basket',
        'Sweet Thoughts',
        'Teleflora\'s Be My Love',
        'Timeless Romance',
        'Deluxe Red Rose Bouquet',
        'White Orchid Planter',
        'Winter Oasis',
        'Dreamland Bouquet',
        'Admiration Luxury Bouquet',
    ];

    public function run(): void
    {
        foreach ($this->flowerNames as $key => $value) {
            $id = Flower::create([
                'flower_name' => $value,
                'active' => 1,
                'image_id' => $key + 1,
            ]);

            for ($j = 0; $j < rand(1, 3); $j++) {
                DB::table('category_flowers')->updateOrInsert([
                    'flower_id' => $id->id_flower,
                    'category_id' => rand(1, 9),
                ]);
            }
        }
    }
}
