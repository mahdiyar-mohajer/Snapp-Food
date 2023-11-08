<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\FoodCategory;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function getFoods($restaurant_id)
    {

        $foods = Food::where('resturant_id', $restaurant_id)->get();

        return response()->json(['foods' => $foods]);
    }
}
