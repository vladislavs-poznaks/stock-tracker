<?php

namespace App\UseCases;

use App\Clients\StockStatus;
use App\Events\NowAvailable;
use App\Models\History;
use App\Models\Stock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;

class TrackStock
{
    private Stock $stock;
    private StockStatus $status;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function handle()
    {
        $this->checkAvailability();
        $this->notifyUser();
        $this->refreshStock();
        $this->recordToHistory();
    }

    protected function checkAvailability()
    {
        $this->status = $this->stock
            ->retailer
            ->client()
            ->checkAvailability($this->stock);
    }

    protected function notifyUser()
    {
        if ($this->isNowAvailable()) {
            User::first()->notify(
                new ImportantStockUpdate($this->stock)
            );
        }
    }

    protected function refreshStock()
    {
        $this->stock->update([
            'available' => $this->status->available,
            'price' => $this->status->price
        ]);
    }

    protected function recordToHistory()
    {
        History::create([
            'stock_id' => $this->stock->id,
            'product_id' => $this->stock->product_id,
            'price' => $this->stock->price,
            'available' => $this->stock->available
        ]);
    }

    protected function isNowAvailable(): bool
    {
        return !$this->stock->available && $this->status->available;
    }
}
