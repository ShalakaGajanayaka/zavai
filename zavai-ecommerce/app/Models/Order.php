<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'address',
        'phone',
        'total_amount',
        'status',
    ];

    // එක Order එකකට OrderItems ගොඩක් තියෙන්න පුළුවන් (hasMany)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // එක Order එකක් අයිති එක User කෙනෙක්ට (belongsTo)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
