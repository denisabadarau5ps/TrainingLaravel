<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * The orders that belong to the product
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('product_price');
    }

    /**
     * Get the approved ratings for the product
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Rating::class)->where('approved', '=', '1')->orderBy('created_at', 'desc');
    }
}
