<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $adminMenu = [
        [
            'route' => 'admin.users',
            'name' => 'Users'
        ],
        [
            'route' => 'admin.products',
            'name' => 'Products'
        ],
        [
            'route' => 'admin.userLogs',
            'name' => 'User Logs'
        ]
    ];

    public function register(): void
    {
    }

    public function boot(): void
    {
        $menu = Menu::all();
        View::share('menu', $menu);
        View::share('adminMenu', $this->adminMenu);
        Paginator::useBootstrapFive();
    }
}
