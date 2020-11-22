<?php

namespace Tests\Integration;

use App\Models\History;
use App\Models\Stock;
use App\Notifications\ImportantStockUpdate;
use App\UseCases\TrackStock;
use Database\Seeders\RetailerWithProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notification;
use Tests\TestCase;

class TrackStockTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        $this->mockClientRequest($available = true, $price = 24900);
        $this->seed(RetailerWithProductSeeder::class);

        (new TrackStock(Stock::first()))->handle();
    }

    /** @test */
    public function it_notifies_the_user()
    {
        Notification::assertTimesSent(1, ImportantStockUpdate::class);
    }

    /** @test */
    public function it_refreshes_the_local_stock()
    {
        $stock = Stock::first();

        $this->assertEquals(24900, $stock->price);
        $this->assertTrue($stock->available);
    }

    /** @test */
    public function it_records_to_history()
    {
        $history = History::first();

        $this->assertEquals(24900, $history->price);
        $this->assertTrue($history->available);
    }
}
