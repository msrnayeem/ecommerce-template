<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'shipping_method',
        'order_notes',
        'coupon',
        'delivery_charge',
        'product_price',
        'shipping_status',
        'status',
        'total_amount',
        'payment_method',
        'payment_id',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
