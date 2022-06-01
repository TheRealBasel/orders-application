<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Restaurant;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meals = Meal::all();
        return response()->json( [
            'success' => true,
            'meals' => $meals
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
        $restaurant = Restaurant::find($request->restaurant);
        if ( $restaurant ){
            if ( !$request->name || empty($request->name) ) {
                response()->json( [
                    'success' => false,
                    'message' => 'Meal name is not valid',
                ], 400 );
            }
            if ( !$request->price || empty($request->price) ) {
                response()->json( [
                    'success' => false,
                    'message' => 'Price is not valid',
                ], 400 );
            }
            $meal = new Meal();

            $meal->name = $request->name;
            $meal->price = $request->price;
    
    
            return $restaurant->Meals()->save($meal) ? 
            response()->json( [
                'success' => true,
                'message' => 'Meal created successfully'
            ], 200 ):
            response()->json( [
                'success' => false,
                'message' => 'Failed to create a meal',
            ], 400 );
    
        }else{
            response()->json( [
                'success' => false,
                'message' => 'Restaurant not found',
            ], 400 );
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
        //
    }
}
