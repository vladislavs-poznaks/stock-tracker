<?php

namespace App\Clients;

use App\Models\Retailer;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

class ClientFactory
{
    public function make(Retailer $retailer): Client
    {
        $class = "App\\Clients\\" . Str::studly($retailer->name);

        if (! class_exists($class)) {
            throw new ClientException('Client not found for ' . $retailer->name);
        }

        return new $class;
    }
}
