<?php

namespace Tests\Unit;

use Facades\App\Clients\ClientFactory;
use App\Clients\StockStatus;
use App\Models\History;
use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_history_each_time_stock_is_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $this->mockClientRequest($available = true, $price = 99);

        $product = Product::first();

        $this->assertCount(0, $product->history);

        $product->track();

        $this->assertCount(1, $product->refresh()->history);

        $history = $product->history->first();
        $this->assertEquals($price, $history->price);
        $this->assertEquals($available, $history->available);
        $this->assertEquals($product->id, $history->product_id);
        $this->assertEquals($product->stock[0]->id, $history->stock_id);
    }
}
