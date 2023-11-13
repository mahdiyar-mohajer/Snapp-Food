<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resturant;

class RestaurantsController extends Controller
{
    public function getRestaurantInfo($restaurant_id)
    {
        $restaurant = Resturant::with('user')->find($restaurant_id);

        if (!$restaurant) {
            return response()->json(['message' => 'رستوران پیدا نشد'], 404);
        }

        return response()->json([
            'restaurant' => $restaurant,
        ],200);
    }

    public function getRestaurants()
    {
        $restaurants = Resturant::all();

        return response()->json([
            'restaurants' => $restaurants,
        ],200);
    }






}
