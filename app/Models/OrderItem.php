<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order;
use App\Models\Meal;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'meal_id', 'price', 'quantity'
    ];

    /**
     * Get the user that owns the OrderItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    /**
     * Get the restaurant that owns the OrderItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}
