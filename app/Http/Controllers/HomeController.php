<?php

namespace App\Http\Controllers;

use App\Models\Flower;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index()
    {
        $products = Flower::with('currentPricing', 'image')->paginate(4);
        return view('pages.home', compact('products'));
    }
}
