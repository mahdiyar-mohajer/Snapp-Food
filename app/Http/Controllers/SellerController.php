<?php

namespace App\Http\Controllers;

use App\Models\Resturant;
use Illuminate\Http\Request;

class SellerController extends Controller
{
//    public function index()
//    {
//        $user = auth()->user();
//        $restaurant = $user->resturant;
//
//        if (!$restaurant || !$restaurant->profile_complete) {
//            return redirect()->route('resturant.profile');
//        }
//
//        return view('seller.dashboard');
//    }

    public function index()
    {
        $user = auth()->user();
        $restaurant = $user->resturant;

        if (!$restaurant || !$restaurant->profile_complete) {
            return redirect()->route('resturant.profile' , compact('restaurant'));
        }

        // Load restaurant data with images
        $restaurantWithImages = Resturant::with('images')->where('id', $restaurant->id)->first();

        return view('seller.dashboard', compact('restaurantWithImages','restaurant'));
    }

}
