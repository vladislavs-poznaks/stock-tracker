<?php

namespace App\Models;

use App\Clients\BestBuy;
use App\Clients\ClientException;
use Facades\App\Clients\ClientFactory;
use Eloquent;
use Exception;
use Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Product
 * @mixin Eloquent
 */
class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $fillable = [
        'price',
        'url',
        'sku',
        'available'
    ];

    protected $casts = [
        'available' => 'boolean'
    ];

    public function track()
    {
        $status = $this->retailer
            ->client()
            ->checkAvailability($this);

        $this->update([
            'available' => $status->available,
            'price' => $status->price
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
