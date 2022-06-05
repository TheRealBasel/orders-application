<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register (Request $request){

        $validated_request = $request->validate([
            'phone_number' => ['required','digits:10','unique:users,phone'],
            'password' => ['required','min:6'],
            'name' => ['required']
        ]);

        $user = User::create([
            'phone' => $validated_request['phone_number'], 
            'password' => Hash::make($validated_request['password']),
            'name' => $validated_request['name']
        ]);
    
        return response()->json( [
            'success' => true,
            'data' => [
                'token' => $user->createToken('orders_app')->plainTextToken
            ],
            'message' => 'You have registerd successfully.'
        ], 201 );
    
    }

    public function login(Request $request){
        $validated_request = $request->validate([
            'phone_number' => ['required'],
            'password' => ['required'],
        ]);
        if(Auth::attempt(['phone' => $validated_request['phone_number'], 'password' => $validated_request['password']])){ 
            
            $user = Auth::user(); 

            return response()->json( [
                'success' => true,
                'message' => 'Successfully Logged in',
                'data' => [
                    'token' => $user->createToken('orders_app')->plainTextToken
                ]
            ], 200 );
        }
        return response()->json( [
            'success' => false,
            'message' => 'credeaintls dont match our records'
        ], 401 );
    }

    public function logout (Request $request){
        Auth::logout();
        return response()->json( [
            'success' => true,
            'message' => 'You have been successfully logged out.'
        ], 200 );
    }
}
