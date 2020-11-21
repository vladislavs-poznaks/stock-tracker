<?php

namespace App\Clients;

class StockStatus
{
    public bool $available;
    public int $price;

    public function __construct(bool $available, int $price)
    {
        $this->available = $available;
        $this->price = $price;
    }

}
