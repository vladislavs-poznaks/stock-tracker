<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_for_product_stock_at_retailers()
    {
        $nintendoSwitch = Product::create([
            'name' => 'Nintendo Switch'
        ]);

        $bestBuy = Retailer::create([
            'name' => 'Best Buy'
        ]);

        $this->assertFalse($nintendoSwitch->inStock());

        $stock = new Stock([
            'price' => 10000,
            'url' => 'example.com',
            'sku' => '12345',
            'available' => true
        ]);

        $bestBuy->addStock($nintendoSwitch, $stock);

        $this->assertTrue($nintendoSwitch->inStock());
    }
}
