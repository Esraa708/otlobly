<?php

namespace App\Http\Controllers;

use App\Events\createOrder;
use App\Http\Requests\OrderRequest;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function allOrders()
    {
        return view("allorders");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("addorder");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $order = new Order();
        $groups = explode(",", $request->groups);
        $friends = explode(",", $request->friends);
        // dd($groups);
        $order->meal = $request->meal;
        $order->restaurant_name = $request->from;
        $order->status = $request->status;
        $order->meal = $request->meal;
        if ($request->hasFile('photo')) {
            $path = $request->photo->store('menus');
            $order->menu_image = $path;
        }
        auth()->user()->manyOrders()->save($order);
        $order->save();

        foreach ($groups as $group) {
            $order->groups()->attach($group);
        }
        foreach ($friends as $friend) {
            $order->friends()->attach($friend);
        }
        foreach ( $order->friends as $friend) {
            event(new createOrder($friend, $order));
        }
        return response("order created successfully", 200);
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
        //
    }
}
