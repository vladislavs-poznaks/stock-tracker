<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\RetailerWithProductSeeder;
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
}
