<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Detail extends Model
{
    protected $fillable = [
        'item', 'amount', 'price', 'comment'
    ];
}
