<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @mixin Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function track()
    {
        $this->stock->each->track();
    }

    public function inStock(): bool
    {
        return $this->stock()->where('available', true)->exists();
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
