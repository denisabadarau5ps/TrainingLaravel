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
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot(['product_price']);
    }
}
