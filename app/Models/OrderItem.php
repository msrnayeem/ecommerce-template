<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'order_id',
        'orderable_id',
        'orderable_type',
        'name',
        'sku',
        'unit_price',
        'quantity',
        'total',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderable()
    {
        return $this->morphTo();
    }

    public function scopeTopSelling($query, $limit = 5)
    {
        return $query->select([
            'order_items.orderable_type',
            'order_items.orderable_id',
            'order_items.name',
            'order_items.sku',
            DB::raw('SUM(order_items.quantity) as total_quantity_sold'),
        ])
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereNull('order_items.deleted_at')
            ->whereNull('orders.deleted_at')
            ->where('orders.status', 'completed')
            ->groupBy('order_items.orderable_type', 'order_items.orderable_id', 'order_items.name', 'order_items.sku')
            ->orderByDesc('total_quantity_sold')
            ->limit($limit)
            ->with(['orderable' => function ($q) {
                $q->with(['product' => function ($subQ) {
                    $subQ->select('id', 'name', 'sku');
                }, 'variant', 'variantValue']);
            }]);
    }
}
