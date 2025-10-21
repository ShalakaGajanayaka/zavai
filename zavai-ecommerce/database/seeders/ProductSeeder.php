<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing categories
        $categories = Category::all();
        
        if ($categories->count() > 0) {
            // Create some sample products for each category
            foreach ($categories as $category) {
                // Create 3-4 products for each category
                for ($i = 1; $i <= 4; $i++) {
                    Product::create([
                        'name' => $category->name . ' Product ' . $i,
                        'sku' => strtoupper($category->slug) . '-' . $i,
                        'price' => rand(1000, 5000), // Random price between 1000-5000
                        'description' => 'High quality ' . strtolower($category->name) . ' product ' . $i,
                        'category_id' => $category->id,
                        'image_path' => null, // No image for now
                    ]);
                }
            }
        }
    }
}