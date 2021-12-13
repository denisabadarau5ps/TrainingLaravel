<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Customer extends Model
{
    use HasFactory;
    /**
     * Get the order record associated with the user
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
