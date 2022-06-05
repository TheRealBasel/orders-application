<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Meal;
use App\Models\OrderItem;

use Illuminate\Support\Facades\Auth;

use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new OrderCollection (Order::with('items')->get());
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

        $restaurant = Restaurant::findOrFail($request->restaurant);

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

        return new OrderResource($created_order);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new OrderResource(Order::with('items')->findOrFail($id));
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
