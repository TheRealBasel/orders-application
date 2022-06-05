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
        $validated_request = $request->validate([
            'restaurant_name' => ['required', 'exists:restaurants,name'],
            'items' => ['required', 'array']
        ]);

        $restaurant = Restaurant::find($request->restaurant);

        $user = Auth::user();

        $created_order = Order::create([
            'user_id' => $uesr->id,
            'restaurant_id' => $restaurant->id
        ]);

        foreach ($validated_request->items as $item) {
            OrderItem::create([
                'order_id' => $created_order->id,
                'meal_id' => $item->meal_id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);
        }

        return response()->json( [
            'success' => true,
            'message' => $created_order
        ], 200 );
                
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
