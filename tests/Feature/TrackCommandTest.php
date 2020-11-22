<?php

namespace Tests\Feature;

use App\Clients\StockStatus;
use App\Models\Product;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use Database\Seeders\RetailerWithProductSeeder;
use Facades\App\Clients\ClientFactory;
use Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notification;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        $this->seed(RetailerWithProductSeeder::class);
    }

    /** @test */
    public function it_tracks_product_stock()
    {
        $this->assertFalse(Product::first()->inStock());

        Http::fake(fn() => ['onlineAvailability' => true, 'salePrice' => 29900]);

        $this->artisan('track')
            ->expectsOutput('All done!');

        $this->assertTrue(Product::first()->inStock());
    }

    /** @test */
    public function it_does_not_notify_when_the_stock_remains_unavailable()
    {
        $this->mockClientRequest($available = false);

        $this->artisan('track');

        Notification::assertNotSentTo(User::first(), ImportantStockUpdate::class);
    }

    /** @test */
    public function it_notifies_the_user_when_the_stock_is_now_available()
    {
        $this->mockClientRequest();

        $this->artisan('track');

        Notification::assertSentTo(User::first(), ImportantStockUpdate::class);
    }

}
