<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\addFriendToGroupREquest;
use App\User;
use Illuminate\Http\Request;

class GropupFreindsController extends Controller
{
    public function store(addFriendToGroupREquest $request)
    {
        $friend = User::where('name', $request->friendName)->first();
        $userFriends = auth()->user()->friends;
        if ($userFriends->contains($friend)) {
            $group = Group::find($request->id);
            $group->friends()->syncWithoutDetaching($friend);
            return response('friend is added to ' . $group->name . ' successfully');
        } else {
            return response('error cant add friend to group', 404);
        }
    }
    public function index($id){
        $groupFriends=Group::where('id',$id)->first()->friends;
        return response(['friends' => $groupFriends]);
    }
}
