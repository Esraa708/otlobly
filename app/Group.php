<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'image'
    ];
    public function users()
    {
        return $this->belongsTo('App\User');
    }
    public function friends()
    {
        return $this->belongsToMany('App\User', 'group_friend', 'group_id', 'friend_id');
    }
}
