<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $validatedData = $request->validate([ // Validate the incoming data
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'color' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public'); // 'public' disk එකේ, 'products' folder එකක් ඇතුළේ image එක save කරනවා
            $validatedData['image_url'] = Storage::url($path); // Save කරපු file එකේ URL එක database එකට දාන්න හදාගන්නවා
        }


        unset($validatedData['image']); // image එක database එකට යවන්නේ නෑ

        $product = Product::create($validatedData); // Create the new product
        return response()->json($product, 201);  // Return the new product with a 201 Created status
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product; // Laravel's Route Model Binding automatically finds the product by its ID and returns a 404 error if not found. So simple!
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // පරණ image එකක් තියෙනවා නම්, ඒක delete කරනවා
            if ($product->image_url) {
                $oldPath = str_replace('/storage', '', $product->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            unset($validatedData['image']);


            $path = $request->file('image')->store('products', 'public'); // අලුත් image එක save කරනවා
            $validatedData['image_url'] = Storage::url($path);
        }

        $product->update($validatedData); // Update the product

        return response()->json($product); // Return the updated product
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
