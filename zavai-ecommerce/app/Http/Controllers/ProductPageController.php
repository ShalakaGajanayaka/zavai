<?php

namespace App\Http\Controllers;

use App\Models\Product; // Product model එක import කරගන්න
use App\Models\Category; // Category model එක import කරගන්න
use Illuminate\Http\Request;
use Inertia\Inertia; // Inertia import කරගන්න

class ProductPageController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Sort by latest first
        $products = $query->latest()->paginate(12);
        
        // Get all categories for filter
        $categories = Category::all();
        
        return Inertia::render('Frontend/Products/Index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['category', 'search'])
        ]);
    }

    public function show(Product $product)
    {
        // Route Model Binding නිසා, Laravel විසින්ම ID එකට අදාල product එක හොයලා දෙනවා
        return Inertia::render('Frontend/Products/Show', [
            'product' => $product
        ]);
    }
}