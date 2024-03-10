<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    private $names = ['Home', 'Products', 'Register', 'Author'];
    private $routes = ['home', 'products', 'register', 'author'];
    public function run(): void
    {
        for ($i = 0; $i < count($this->names); $i++) {
            Menu::create([
                'name' => $this->names[$i],
                'route' => $this->routes[$i],
                'order' => $i,
            ]);
        }
    }
}
