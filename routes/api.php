<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\RestaurantController;
use App\Http\Controllers\api\MealController;

Route::delete('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group( function () {
    Route::resource ('restaurant', RestaurantController::class);
    Route::resource ('meal', MealController::class);
    Route::resource ('order', MealController::class);

});

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');

});