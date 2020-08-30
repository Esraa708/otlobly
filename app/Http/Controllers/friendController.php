<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class friendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userFriends = Auth::user()->friends;

        // dd(storage_path());
        return response(['friends' => $userFriends]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('friends');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FriendRequest $request)
    {

        if (User::where('email', $request->email)->exists() && (auth()->user()->email != $request->email)) {
            $user = User::where('email', $request->email)->first();
            $userFriends = Auth::user()->friends()->pluck('friend_id');
            if ($userFriends->contains($user->id)) {
                return response(['message' => 'you are already friends'], 404);
            } else {
                Auth::user()->friends()->attach($user->id);
                return response('friend added successfully', 200);
            }
        } else {
            return response(['message' => 'couldnt find this email please add a valid email'], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->user()->friends()->detach($id);
        return response('unfriend successfully',200);
    }
}
