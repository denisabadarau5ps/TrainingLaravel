<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    /**
     * Get the customer that owns the order
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The products that belong to the order
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('product_price');
    }
}
