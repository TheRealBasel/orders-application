<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\RestaurantCollection;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RestaurantCollection(Restaurant::paginate());

        // return response()->json( [
        //     'success' => true,
        //     'restaurants' => $restaurants
        // ], 200 );
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
            'restaurant_name' => ['requierd', 'unique:restaurants,name']
        ]);


        $created_restaurant = Restaurant::create([
            'name' => $validated_request->restaurant_name
        ]);

        // return response()->json( [
        //     'success' => true,
        //     'message' => 'Restaurant created successfully',
        //     'data' => $created_restaurant
        // ], 201 );
        return new RestaurantResource($created_restaurant);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new RestaurantResource(Restaurant::findOrFail($id));

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
