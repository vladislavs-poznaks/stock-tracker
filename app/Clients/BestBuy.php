<?php

namespace App\Clients;

use App\Models\Stock;
use Http;

class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {
        $results = Http::get($this->getEndpoint($stock->sku))->json();

        return new StockStatus(
            $results['onlineAvailability'],
            $this->dollarsToCents($results['salePrice'])
        );
    }

    protected function getEndpoint($sku): string
    {
        $key = config('services.clients.bestBuy.key');

        return "https://api.bestbuy.com/v1/products/{$sku}.json?apiKey={$key}";
    }

    protected function dollarsToCents($dollars): int
    {
        return $dollars * 100;
    }
}
