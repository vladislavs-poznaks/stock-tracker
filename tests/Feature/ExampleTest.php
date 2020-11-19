<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_for_product_stock_at_retailers()
    {
        $nintendoSwitch = Product::create([
            'name' => 'Nintentdo Switch'
        ]);

        $bestBuy = Retailer::create([
            'name' => 'Best Buy'
        ]);

        $this->assertFalse($nintendoSwitch->isStock());
    }
}
