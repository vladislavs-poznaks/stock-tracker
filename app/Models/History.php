<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @mixin Eloquent
 */
class History extends Model
{
    use HasFactory;

    protected $table = 'product_history';

    protected $fillable = [
        'stock_id',
        'product_id',
        'price',
        'available'
    ];

    protected $casts = [
        'available' => 'boolean'
    ];
}
