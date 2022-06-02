<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Meal;
use App\Models\OrderItem;

use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('items')->get();
        return response()->json( [
            'success' => true,
            'orders' => $orders
        ], 200 );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( $request->restaurant ){
            $restaurant = Restaurant::find($request->restaurant);
            if ( $restaurant ){
                $user = Auth::user();
                $order = Order::where('user_id', $user->id)->where('restaurant_id', $restaurant->id)->get();
                $items = $request->items;
                if ( $order && !empty($order) && sizeof($order) > 0 ){
                    return response()->json( [
                        'success' => false,
                        'message' => 'You already have an open order.'
                    ], 400 );
                }else{
                    if ( !$request->items || empty($request->items) || sizeof($request->items) < 1 ){
                        return response()->json( [
                            'success' => false,
                            'message' => "You can't make order without any meal"
                        ], 400 );
                    }
                    $new_order = new Order();
                    $new_order->user_id = $user->id;
                    $new_order->restaurant_id = $restaurant->id;
                    $new_order->save();

                    foreach ($request->items as $key => $item) {
                        $new_item = new OrderItem();
                        $new_item->order_id = $new_order->id;
                        $new_item->meal_id = $item['meal'];
                        $new_item->quantity = $item['quantity'];
                        $new_item->price = $item['price'];
                        $new_item->save();
                    }

                    return response()->json( [
                        'success' => true,
                        'message' => $new_order
                    ], 200 );
                }
            }
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
        $order = Order::with('items')->find($id);
        if ( $order ){
            return response()->json( [
                'success' => true,
                'order' => $order
            ], 200 );
        }else{
            return response()->json( [
                'success' => false,
                'message' => "There is no order with this id"
            ], 400 );
        }
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
