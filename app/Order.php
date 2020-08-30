<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'meal', 'restaurant_name', 'status', 'menu_image',
    ];
}
