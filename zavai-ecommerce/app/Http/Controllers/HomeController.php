<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product; // Product model එක import කරගන්න
use Illuminate\Http\Request;
use Inertia\Inertia; // Inertia import කරගන්න

class HomeController extends Controller
{
    public function index()
    {
        $categoriesWithProducts = Category::whereHas('products')
            ->with(['products' => function ($query) {
                $query->latest()->take(4);
            }])
            ->get();

        // Debug: Log the data to see what's being passed
        \Log::info('Categories with products:', $categoriesWithProducts->toArray());

        return Inertia::render('Frontend/Home', [
            'categories' => $categoriesWithProducts
        ]);
    }
}
