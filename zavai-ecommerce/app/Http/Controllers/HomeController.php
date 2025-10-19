<?php

namespace App\Http\Controllers;

use App\Models\Product; // Product model එක import කරගන්න
use Illuminate\Http\Request;
use Inertia\Inertia; // Inertia import කරගන්න

class HomeController extends Controller
{
    public function index()
    {
        // අලුත්ම products ටික උඩින්ම එන විදිහට database එකෙන් ගන්නවා
        $products = Product::latest()->get();

        // 'Frontend/Home' කියන Vue component එකට, $products ටිකත් එක්ක යවනවා
        return Inertia::render('Frontend/Home', [
            'products' => $products
        ]);
    }
}
