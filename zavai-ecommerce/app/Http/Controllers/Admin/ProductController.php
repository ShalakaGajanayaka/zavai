<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'sku' => 'required|max:255|unique:products', // sku එක products table එකේ unique වෙන්න ඕන
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Product::create($validatedData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }


    public function show(string $id)
    {
        //
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }


    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'sku' => ['required', 'max:255', Rule::unique('products')->ignore($product->id)],
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $product->update($validatedData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }


    public function destroy(string $id)
    {
        //
    }
}
