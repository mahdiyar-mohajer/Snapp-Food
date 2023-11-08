<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\FoodCategory;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function getFoods()
    {

        $foods = Food::all();

        // You can return the $foods as a response or use an API resource to format the response
        // For example, you can return the $foods as JSON:
        return response()->json($foods);
    }
}
