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

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function meal(){
        return $this->belongsTo(Meal::class);
    }
}
