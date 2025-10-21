<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'T-Shirts', 'slug' => 't-shirts']);
        Category::create(['name' => 'Shirts', 'slug' => 'shirts']);
        Category::create(['name' => 'Shorts', 'slug' => 'shorts']);
        Category::create(['name' => 'Beach Outfits', 'slug' => 'beach-outfits']);
    }
}
