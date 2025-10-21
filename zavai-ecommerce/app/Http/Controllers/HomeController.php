<?php

namespace App\Http\Controllers;

use App\Models\Product; // Product model එක import කරගන්න
use Illuminate\Http\Request;
use Inertia\Inertia; // Inertia import කරගන්න

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::latest()->take(4)->get();

        return Inertia::render('Frontend/Home', [
            'featuredProducts' => $featuredProducts
        ]);
    }
}
