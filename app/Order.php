<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'meal', 'restaurant_name', 'status', 'menu_image',
    ];

    public function groups()
    {
        return $this->belongsToMany('App\Order', 'order_group', 'order_id', 'group_id');
    }
    //order friend relation
    public function friends()
    {
        return $this->belongsToMany('App\User', 'order_friend', 'order_id', 'friend_id');
    }
    //order owner relation
    public function owner()
    {
        return $this->belongsTo('App\User', 'order_owner_id');
    }
}
