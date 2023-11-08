<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resturant;

class RestaurantsController extends Controller
{
    public function getRestaurantInfo($restaurant_id)
    {
        $restaurant = Resturant::with('user')->find($restaurant_id); // Use 'find' to retrieve a specific restaurant by its ID.

        if (!$restaurant) {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }

        return response()->json([
            'restaurant' => $restaurant,
        ]);
    }

    public function getRestaurants()
    {
        $restaurants = Resturant::all();

        return response()->json([
            'restaurants' => $restaurants,
        ]);
    }






}
