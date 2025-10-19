<?php

namespace App\Http\Controllers;

use App\Models\Product; // Product model එක import කරගන්න
use Illuminate\Http\Request;
use Inertia\Inertia; // Inertia import කරගන්න

class ProductPageController extends Controller
{
    public function show(Product $product)
    {
        // Route Model Binding නිසා, Laravel විසින්ම ID එකට අදාල product එක හොයලා දෙනවා
        return Inertia::render('Frontend/Products/Show', [
            'product' => $product
        ]);
    }
}