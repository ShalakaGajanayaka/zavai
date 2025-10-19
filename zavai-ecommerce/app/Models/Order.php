<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
