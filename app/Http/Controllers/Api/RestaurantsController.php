<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resturant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        ], 200);
    }

    public function getRestaurants()
    {
        $user = Auth::user();

        $userLatitude = (double) $user->latitude;
        $userLongitude = (double) $user->longitude;

        $restaurants = DB::table('resturants')
            ->join('addresses', 'resturants.address_id', '=', 'addresses.id')
            ->select('resturants.*', 'addresses.latitude', 'addresses.longitude')
            ->selectRaw("6371 * acos(cos(radians(?)) * cos(radians(addresses.latitude)) * cos(radians(addresses.longitude) - radians(?)) + sin(radians(?)) * sin(radians(addresses.latitude))) AS distance", [
                $userLatitude,
                $userLongitude,
                $userLatitude
            ])
            ->orderBy('distance')
            ->get();

        $restaurants = $restaurants->map(function ($restaurant) {
            $restaurant->distance = round($restaurant->distance, 2);
            return $restaurant;
        });

        return response()->json([
            'resturants' => $restaurants
        ], 200);
    }


}
