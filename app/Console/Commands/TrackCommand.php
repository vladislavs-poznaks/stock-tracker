<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class TrackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track all product stock';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::all();

        $this->output->progressStart($products->count());

        $products->each(function ($product) {
            $product->track();
            $this->output->progressAdvance();
        });

        $data = Product::query()
            ->leftJoin('stock', 'stock.product_id', '=', 'products.id')
            ->get($this->keys())
            ->toArray();

        $this->showResults($data);
    }

    protected function keys(): array
    {
        return ['name', 'price', 'available'];
    }

    protected function showResults(array $data): void
    {
        $this->output->progressFinish();
        $this->table(
            array_map('ucwords', $this->keys()),
            $data
        );
    }
}
