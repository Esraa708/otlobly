<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function friends()
    {
        return $this->belongsToMany('App\User', 'user_friend', 'user_id', 'friend_id');
    }
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function groups()
    {
        return $this->hasMany('App\Group');
    }
    //friends groups
    public function groupsForFriends()
    {
        return $this->belongsToMany('App\Group', 'group_friend', 'friend_id', 'group_id');
    }
    //order friend relation
    public function orders()
    {
        return $this->belongsToMany('App\Order', 'order_friend', 'friend_id', 'order_id');
    }

 //order owner relation
    public function manyOrders()
    {
        return $this->hasMany('App\Order', 'order_owner_id');
    }
   
}
