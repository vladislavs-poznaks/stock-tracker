<?php

namespace App\Models;

use Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        if ($this->retailer->name === 'Best Buy') {
            $response = Http::get('http://foo.bar')->json();

            $this->update([
                'available' => $response['available'],
                'price' => $response['price']
            ]);
        }
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }
}
