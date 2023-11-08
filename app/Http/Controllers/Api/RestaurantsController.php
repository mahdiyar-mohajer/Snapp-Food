<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resturant;

class RestaurantsController extends Controller
{
    public function getRestaurantInfo($restaurant_id)
    {
        $restaurant=Resturant::with('user')->where('id',$restaurant_id)->first();
        return response()->json(
            [
                'restaurant' => $restaurant,
            ]
        );
    }

    public function getRestaurants()
    {
        $restaurants=Resturant::all();
        return response()->json(
            [
                'restaurants' => $restaurants,
            ]
        );
    }
}
