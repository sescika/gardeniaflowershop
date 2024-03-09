<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $categories = [
        'best sellers',
        'any occasion flowers',
        'birthday flowers',
        'just because',
        'graduation',
        'love and romance',
        'rose bouquets',
        'thank you flowers',
        'spring flowers'
    ];
    public function run(): void
    {

        foreach ($this->categories as $c) {
            Category::create([
                'category_name' => $c
            ]);
        }
    }
}
