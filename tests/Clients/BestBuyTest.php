<?php

namespace Tests\Clients;

use App\Clients\BestBuy;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Exception;
use Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class BestBuyTest
 * @group api
 */
class BestBuyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_tracks_a_product()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $stock = tap(Stock::first())->update([
            'sku' => '6257135',
            'url' => 'https://www.bestbuy.com/site/nintendo-switch-32gb-lite-gray/6257135.p?skuId=6257135'
        ]);

        try {
            (new BestBuy())->checkAvailability($stock);
        } catch (Exception $e) {
            $this->fail('Failed to track Best Buy API. ' . $e->getMessage());
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function it_creates_a_proper_stock_status_response()
    {
        Http::fake(fn () => ['salePrice' => 299.99, 'onlineAvailability' => true]);

        $status = (new BestBuy())->checkAvailability(new Stock());

        $this->assertEquals(29999, $status->price);
        $this->assertEquals(true, $status->available);
    }
}
