<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // අදාල category එකට අයිති products, පිටුවකට 12 ගානේ paginate කරලා ගන්නවා
        $products = $category->products()->latest()->paginate(12);

        return Inertia::render('Frontend/Category/Show', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}