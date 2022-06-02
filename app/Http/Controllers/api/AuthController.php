<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function register (Request $request){
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|digits:10',
            'password' => 'required|min:6',
            'name' => 'required'
        ]);
 
        if ($validator->fails()) {
            return response()->json( [
                'success' => false,
                'message' => 'Please check your credentials.'
            ], 400 );
        }
        $user = User::where('phone', '=', $request['phone_number'])->first();
        if ($user === null) {

            $user = User::create([
                'phone' => $request['phone_number'], 
                'password' => bcrypt($request['password']), 
                'name' => $request['name']
            ]);
    
            return response()->json( [
                'success' => true,
                'data' => [
                    'token' => $user->createToken('orders_app')->plainTextToken
                ],
                'message' => 'You have registerd successfully.'
            ], 200 );
    
        }else{
            return response()->json( [
                'success' => false,
                'message' => 'Phone Number already used.'
            ], 400 );
        }
    }

    public function login(Request $request){
        if(Auth::attempt(['phone' => $request->phone_number, 'password' => $request->password])){ 
            
            $user = Auth::user(); 

            return response()->json( [
                'success' => true,
                'message' => 'Successfully Loggedin',
                'data' => [
                    'token' => $user->createToken('orders_app')->plainTextToken
                ]
            ], 200 );
        }else{ 
            return response()->json( [
                'success' => false,
                'message' => 'Please check your credentials',
            ], 400 );
        }
    }

    public function logout (Request $request){
        if ( Auth::check() ){
            $isTokenDeleted = $request->user()->currentAccessToken()->delete();
            if ( $isTokenDeleted ){
                return response()->json( [
                    'success' => true,
                    'message' => 'You have been successfully logged out.'
                ], 200 );
            }else{
                return response()->json( [
                    'success' => false,
                    'message' => 'Please contact adminstrator.'
                ], 400 );
            }
        }
        return response()->json( [
            'success' => false,
            'message' => 'Not Logged in',
        ], 400 );
    }
}
