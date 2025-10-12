<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'color' => 'required|string|max:50',
            'image_url' => 'required|url',
        ]);

        // Create the new product
        $product = Product::create($validatedData);

        // Return the new product with a 201 Created status
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Laravel's Route Model Binding automatically finds the product by its ID
        // and returns a 404 error if not found. So simple!
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'color' => 'required|string|max:50',
            'image_url' => 'required|url',
        ]);

        // Update the product
        $product->update($validatedData);

        // Return the updated product
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete the product
        $product->delete();

        // Return a success response with no content (204)
        return response()->json(null, 204);
    }
}
