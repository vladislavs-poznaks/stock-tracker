<?php

namespace Tests\Unit;

use App\Clients\Client;
use App\Clients\ClientException;
use App\Clients\StockStatus;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\RetailerWithProductSeeder;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_an_exception_if_client_is_not_found()
    {
        $this->seed(RetailerWithProductSeeder::class);

        Retailer::first()->update([
            'name' => 'Foo Retailer'
        ]);

        $this->expectException(ClientException::class);

        Stock::first()->track();
    }

    /** @test */
    public function it_updates_local_stock_status_after_being_tracked()
    {
        $this->seed(RetailerWithProductSeeder::class);

        $this->mockClientRequest();

        $stock = tap(Stock::first())->track();

        $this->assertTrue($stock->available);
        $this->assertEquals(29900, $stock->price);
    }
}
