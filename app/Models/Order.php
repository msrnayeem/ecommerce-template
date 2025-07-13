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
        'discount_amount',     // ✅ New field
        'delivery_charge',
        'total_amount',
        'status',              // ✅ Combined status
        'payment_method',
        'payment_id',
        'payment_status',
        'payment_response',    // ✅ New field
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'status' => 'string',
        'payment_status' => 'string',
        'payment_response' => 'array', // ✅ Cast JSON response as array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Calculate total amount from order items, delivery charge, and discount
    public function calculateTotal()
    {
        $itemsTotal = $this->orderItems->sum('total');
        $delivery = $this->delivery_charge ?? 0;
        $discount = $this->discount_amount ?? 0;

        return $itemsTotal + $delivery - $discount;
    }
}
