<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    private $names = ['Home', 'Products', 'Register'];
    private $routes = ['home', 'products', 'register'];
    public function run(): void
    {
        for($i = 0; $i < count($this->names); $i++){
            DB::table('menus')->insert([
                'name' => $this->names[$i],
                'route' => $this->routes[$i],
                'order' => $i,
            ]);
        }
    }
}
