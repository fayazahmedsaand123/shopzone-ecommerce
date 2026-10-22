<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $cats = [
            ['name' => 'Electronics',    'icon' => 'bi-laptop',       'sort_order' => 1],
            ['name' => 'Mobile Phones',  'icon' => 'bi-phone',        'sort_order' => 2],
            ['name' => 'Fashion',        'icon' => 'bi-bag',          'sort_order' => 3],
            ['name' => 'Home & Living',  'icon' => 'bi-house',        'sort_order' => 4],
            ['name' => 'Sports',         'icon' => 'bi-bicycle',      'sort_order' => 5],
            ['name' => 'Books',          'icon' => 'bi-book',         'sort_order' => 6],
            ['name' => 'Toys & Kids',    'icon' => 'bi-controller',   'sort_order' => 7],
            ['name' => 'Health & Beauty','icon' => 'bi-heart-pulse',  'sort_order' => 8],
        ];

        foreach ($cats as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                ['name' => $cat['name'], 'status' => 'active', 'sort_order' => $cat['sort_order']]
            );
        }

        // Brands
        $brands = ['Samsung', 'Apple', 'Sony', 'LG', 'Nike', 'Adidas', 'HP', 'Dell'];
        foreach ($brands as $b) {
            Brand::firstOrCreate(
                ['slug' => Str::slug($b)],
                ['name' => $b, 'status' => 'active']
            );
        }

        // Products
        $electronics = Category::where('slug', 'electronics')->first();
        $mobiles     = Category::where('slug', 'mobile-phones')->first();
        $fashion     = Category::where('slug', 'fashion')->first();
        $samsung     = Brand::where('slug', 'samsung')->first();
        $apple       = Brand::where('slug', 'apple')->first();
        $nike        = Brand::where('slug', 'nike')->first();

        $products = [
            ['name' => 'Samsung Galaxy S24 Ultra',  'price' => 285000, 'sale_price' => 265000, 'stock' => 15, 'cat' => $mobiles,     'brand' => $samsung, 'featured' => true],
            ['name' => 'Apple iPhone 15 Pro Max',   'price' => 350000, 'sale_price' => 330000, 'stock' => 10, 'cat' => $mobiles,     'brand' => $apple,   'featured' => true],
            ['name' => 'Samsung 55" 4K Smart TV',   'price' => 120000, 'sale_price' => 99000,  'stock' => 8,  'cat' => $electronics, 'brand' => $samsung, 'featured' => true],
            ['name' => 'Samsung Galaxy Tab S9',     'price' => 95000,  'sale_price' => null,   'stock' => 12, 'cat' => $electronics, 'brand' => $samsung, 'featured' => false],
            ['name' => 'Apple MacBook Air M2',      'price' => 290000, 'sale_price' => 275000, 'stock' => 5,  'cat' => $electronics, 'brand' => $apple,   'featured' => true],
            ['name' => 'Nike Air Max 270',          'price' => 18000,  'sale_price' => 15000,  'stock' => 30, 'cat' => $fashion,     'brand' => $nike,    'featured' => false],
            ['name' => 'Samsung Galaxy Buds 2 Pro', 'price' => 35000,  'sale_price' => 29000,  'stock' => 20, 'cat' => $electronics, 'brand' => $samsung, 'featured' => false],
            ['name' => 'Nike Dri-FIT Running Shirt','price' => 4500,   'sale_price' => 3500,   'stock' => 50, 'cat' => $fashion,     'brand' => $nike,    'featured' => false],
        ];

        foreach ($products as $p) {
            if (!$p['cat']) continue;
            Product::firstOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'name'           => $p['name'],
                    'sku'            => 'SKU-' . strtoupper(Str::random(6)),
                    'price'          => $p['price'],
                    'sale_price'     => $p['sale_price'],
                    'stock_quantity' => $p['stock'],
                    'category_id'    => $p['cat']->id,
                    'brand_id'       => $p['brand']?->id,
                    'is_featured'    => $p['featured'],
                    'status'         => 'active',
                    'short_description' => 'High quality ' . $p['name'] . ' available at ShopZone.',
                ]
            );
        }

        $this->command->info('Sample data seeded successfully.');
    }
}