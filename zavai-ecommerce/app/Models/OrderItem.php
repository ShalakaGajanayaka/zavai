<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    // එක OrderItem එකක් අයිති එක Order එකකට (belongsTo)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // එක OrderItem එකක් අයිති එක Product එකකට (belongsTo)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];
}
