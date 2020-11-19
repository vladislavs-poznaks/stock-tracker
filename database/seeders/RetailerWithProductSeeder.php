<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class RetailerWithProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::create([
            'name' => 'Nintendo Switch'
        ]);

        $retailer = Retailer::create([
            'name' => 'Best Buy'
        ]);

        $retailer->addStock($product, new Stock([
            'price' => 10000,
            'url' => 'example.com',
            'sku' => '12345',
            'available' => false
        ]));
    }
}
