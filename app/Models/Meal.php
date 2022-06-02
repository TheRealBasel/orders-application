<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;

class Meal extends Model
{
    use HasFactory;

    public function Restaurant (){
        return $this->belongsTo(Restaurant::class);
    }
}
